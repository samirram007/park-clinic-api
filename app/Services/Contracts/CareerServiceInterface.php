<?php

namespace App\Services\Contracts;

use App\Http\Requests\CareerRequest;
use App\Models\CareerApplication;

interface CareerServiceInterface
{
    public function apply(CareerRequest $request): CareerApplication;
}
