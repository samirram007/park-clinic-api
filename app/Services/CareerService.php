<?php

namespace App\Services;

use App\Http\Requests\CareerRequest;
use App\Mail\CareerApplicationAcknowledgementMail;
use App\Mail\CareerApplicationMail;
use App\Models\CareerApplication;
use App\Services\Contracts\CareerServiceInterface;
use App\Traits\SendsMail;
use Illuminate\Support\Str;

class CareerService implements CareerServiceInterface
{
    use SendsMail;

    public function apply(CareerRequest $request): CareerApplication
    {
        $file = $request->file('resume');
        $filename = 'resume-'.Str::uuid().'-'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('resumes', $filename, 'public');

        $careerApplication = CareerApplication::create([
            'full_name' => $request->input('fullName'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'position' => $request->input('position'),
            'message' => $request->input('message'),
            'resume_path' => $path,
        ]);

        $this->sendMail(
            new CareerApplicationMail($careerApplication),
            config('mail.contact_receiver'),
            ['application_id' => $careerApplication->id],
        );
        $this->sendMail(
            new CareerApplicationAcknowledgementMail($careerApplication),
            $careerApplication->email,
            ['application_id' => $careerApplication->id],
        );

        return $careerApplication;
    }

}
