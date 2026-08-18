<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CareerApplicationController extends Controller
{
    /**
     * Display a paginated listing of career applications.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search = $request->query('search');

        $query = CareerApplication::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Add resume URL to each application (relative path for proxy compatibility)
        $applications->getCollection()->transform(function ($application) {
            $application->resume_url = $application->resume_path
                ? '/storage/'.$application->resume_path
                : null;
            return $application;
        });

        return response()->json([
            'data' => $applications->items(),
            'meta' => [
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
                'per_page' => $applications->perPage(),
                'total' => $applications->total(),
            ],
        ]);
    }

    /**
     * Display the specified career application.
     */
    public function show(CareerApplication $careerApplication): JsonResponse
    {
        $careerApplication->resume_url = $careerApplication->resume_path
            ? '/storage/'.$careerApplication->resume_path
            : null;

        return response()->json([
            'data' => $careerApplication,
        ]);
    }

    /**
     * Remove the specified career application.
     */
    public function destroy(CareerApplication $careerApplication): JsonResponse
    {
        // Delete resume file
        if ($careerApplication->resume_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($careerApplication->resume_path);
        }

        $careerApplication->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application deleted successfully.',
        ]);
    }
}
