<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\JsonResponse;

class CareerJobController extends Controller
{
    /**
     * Get active job posts for the public career page.
     */
    public function index(): JsonResponse
    {
        $posts = JobPost::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('apply_duration')
                  ->orWhere('apply_duration', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $posts,
        ]);
    }
}
