<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerRequest;
use App\Services\Contracts\CareerServiceInterface;
use Illuminate\Http\JsonResponse;

class CareerController extends Controller
{
    public function __construct(protected CareerServiceInterface $careerService)
    {
    }

    public function apply(CareerRequest $request): JsonResponse
    {
        $this->careerService->apply($request);

        return response()->json(['message' => 'Application submitted successfully'], 201);
    }
}
