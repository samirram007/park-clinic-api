<?php

use App\Mail\CareerApplicationAcknowledgementMail;
use App\Mail\CareerApplicationMail;
use App\Models\CareerApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

// Explicitly enable queue for testing queue assertions
beforeEach(function () {
    config(['mail.queue' => true]);
});

test('a user can apply for a career with a PDF resume', function () {
    Mail::fake();
    Storage::fake('public');

    $file = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

    $response = $this->postJson('/api/career/apply', [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'position' => 'Developer',
        'message' => 'Hello, this is my cover letter.',
        'resume' => $file,
    ]);

    $response->assertStatus(201);

    // Verify it is saved in the database
    $this->assertDatabaseHas('career_applications', [
        'full_name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'position' => 'Developer',
        'message' => 'Hello, this is my cover letter.',
    ]);

    // Get the application path
    $application = CareerApplication::first();
    expect($application->resume_path)->not->toBeNull();

    // Verify file is stored in public disk under resumes/
    Storage::disk('public')->assertExists($application->resume_path);

    // Verify admin notification email was queued with the correct attachment
    Mail::assertQueued(CareerApplicationMail::class, function ($mail) use ($application) {
        return $mail->hasTo(config('mail.contact_receiver')) &&
               $mail->careerApplication->id === $application->id;
    });

    // Verify acknowledgement email was queued to the applicant
    Mail::assertQueued(CareerApplicationAcknowledgementMail::class, function ($mail) use ($application) {
        return $mail->hasTo($application->email) &&
               $mail->careerApplication->id === $application->id;
    });
});

test('a user cannot apply for a career with a non-PDF resume', function () {
    Mail::fake();
    Storage::fake('public');

    $file = UploadedFile::fake()->create('resume.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

    $response = $this->postJson('/api/career/apply', [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'position' => 'Developer',
        'message' => 'Hello, this is my cover letter.',
        'resume' => $file,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['resume']);

    // Verify it is not saved in the database
    $this->assertDatabaseMissing('career_applications', [
        'full_name' => 'John Doe',
    ]);

    // Verify emails were not queued
    Mail::assertNotQueued(CareerApplicationMail::class);
    Mail::assertNotQueued(CareerApplicationAcknowledgementMail::class);
});
