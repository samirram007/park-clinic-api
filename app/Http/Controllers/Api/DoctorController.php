<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DoctorController extends Controller
{
    /**
     * Get doctors list.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Doctor::query();

        // Filter by type: consultant, outdoor, or all (default)
        if ($request->filled('type')) {
            $query->whereJsonContains('type', $request->type);
        }

        // Optional search by name or department
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Only return active doctors to the public frontend
        $query->where('is_active', true);

        // Fetch all, ordered by name
        $doctors = $query->orderBy('name')->get();

        return response()->json([
            'data' => $doctors,
        ]);
    }

    /**
     * Get a single doctor by ID.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $doctor = Doctor::where('id', $id)->where('is_active', true)->firstOrFail();

        return response()->json([
            'data' => $doctor,
        ]);
    }

    /**
     * Serve the doctor's photo image file.
     *
     * Supports both:
     *   - Managed uploads stored in storage/app/public/doctors/
     *   - Static seed images in public/images/
     *
     * @param  int  $id
     * @return BinaryFileResponse|JsonResponse
     */
    public function image(int $id): BinaryFileResponse|JsonResponse
    {
        $doctor = Doctor::where('id', $id)->where('is_active', true)->firstOrFail();

        if (empty($doctor->image)) {
            return response()->json(['message' => 'No image available.'], 404);
        }

        $imagePath = $doctor->image;

        // Managed upload: /storage/doctors/filename.ext → stored in storage/app/public/doctors/
        if (str_starts_with($imagePath, '/storage/')) {
            $relativePath = 'doctors/' . basename($imagePath);

            if (Storage::disk('public')->exists($relativePath)) {
                $fullPath = Storage::disk('public')->path($relativePath);
                return response()->file($fullPath);
            }
        }

        // Static seed image: /images/filename.ext → stored in public/images/
        $publicPath = public_path(ltrim($imagePath, '/'));
        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        return response()->json(['message' => 'Image file not found.'], 404);
    }
}
