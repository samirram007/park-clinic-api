<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    /**
     * Display a paginated listing of job posts.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $status = $request->query('status');
        $search = $request->query('search');

        $query = JobPost::query();

        // Filter by status: active, inactive, expired, or all
        if ($status === 'active') {
            $query->where('is_active', true)
                  ->where(function ($q) {
                      $q->whereNull('apply_duration')
                        ->orWhere('apply_duration', '>=', now()->toDateString());
                  });
        } elseif ($status === 'expired') {
            $query->where(function ($q) {
                $q->where('apply_duration', '<', now()->toDateString());
            });
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Search by title
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->withCount('applications')->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'data' => $posts->items(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ],
        ]);
    }

    /**
     * Store a newly created job post.
     */
    public function store(JobPostRequest $request): JsonResponse
    {
        $data = $request->validated();

        $post = JobPost::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Job post created successfully.',
            'data' => $post,
        ], 201);
    }

    /**
     * Display the specified job post.
     */
    public function show(JobPost $jobPost): JsonResponse
    {
        return response()->json([
            'data' => $jobPost,
        ]);
    }

    /**
     * Update the specified job post.
     */
    public function update(JobPostRequest $request, JobPost $jobPost): JsonResponse
    {
        $data = $request->validated();
        $jobPost->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Job post updated successfully.',
            'data' => $jobPost,
        ]);
    }

    /**
     * Remove the specified job post.
     */
    public function destroy(JobPost $jobPost): JsonResponse
    {
        $jobPost->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job post deleted successfully.',
        ]);
    }
}
