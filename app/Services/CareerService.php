<?php

namespace App\Services;

use App\Http\Requests\CareerRequest;
use App\Models\CareerApplication;
use App\Services\Contracts\CareerServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CareerService implements CareerServiceInterface
{
    public function apply(CareerRequest $request): CareerApplication
    {
        $file = $request->file('resume');
        $filename = 'resume-' . Str::uuid() . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('resumes', $filename, 'public');

        return CareerApplication::create([
            'full_name' => $request->input('fullName'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'position' => $request->input('position'),
            'message' => $request->input('message'),
            'resume_path' => $path,
        ]);
    }
}
