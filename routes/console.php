<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('demo:refresh', function () {
    // Confirm with the user
    if (!$this->confirm('This will delete all existing job posts and career applications. Continue?')) {
        $this->info('Cancelled.');
        return;
    }

    // Truncate existing data
    App\Models\CareerApplication::truncate();
    App\Models\JobPost::truncate();

    $this->info('Cleared existing data.');

    // Re-seed
    $this->call('db:seed', ['--class' => 'JobPostAndApplicationSeeder']);

    $this->info('');
    $this->info('Demo data refreshed successfully!');
    $this->line('   - 20 job posts (active, inactive, expired)');
    $this->line('   - 15 career applications');
})->purpose('Reset and re-seed demo job posts and career applications');
