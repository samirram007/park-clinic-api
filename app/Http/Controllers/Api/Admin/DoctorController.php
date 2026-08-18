<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Directory within public storage where doctor images are stored.
     */
    private const IMAGE_PATH = 'doctors';

    /**
     * Display a paginated listing of doctors.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $type = $request->query('type');
        $status = $request->query('status');
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'type');
        $sortOrder = $request->query('sort_order', 'asc');

        // Whitelist allowed sort columns to prevent SQL injection
        $allowedSortColumns = ['name', 'is_active'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'type';
        }
        $sortOrder = strtolower($sortOrder) === 'desc' ? 'desc' : 'asc';

        $query = Doctor::query();

        if ($type) {
            $query->whereJsonContains('type', $type);
        }

        // Filter by active status: 'active', 'inactive', or all (null/empty)
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Server-side search on name, department, and title
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $doctors = $query->orderBy($sortBy, $sortOrder)->orderBy('name')->paginate($perPage);

        return response()->json([
            'data' => $doctors->items(),
            'meta' => [
                'current_page' => $doctors->currentPage(),
                'last_page' => $doctors->lastPage(),
                'per_page' => $doctors->perPage(),
                'total' => $doctors->total(),
            ],
        ]);
    }

    /**
     * Store a newly created doctor.
     */
    public function store(DoctorRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $doctor = Doctor::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor created successfully.',
            'data' => $doctor,
        ], 201);
    }

    /**
     * Display the specified doctor.
     */
    public function show(Doctor $doctor): JsonResponse
    {
        return response()->json([
            'data' => $doctor,
        ]);
    }

    /**
     * Update the specified doctor.
     */
    public function update(DoctorRequest $request, Doctor $doctor): JsonResponse
    {
        $data = $request->validated();

        // Handle image file upload (replaces old image)
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            $this->deleteImageFile($doctor->image);
            $data['image'] = $this->uploadImage($request->file('image'));
        } else {
            // No new file uploaded — image comes through as a string URL or null
            // If the string is empty, set to null and clean up old file
            if (empty($data['image'])) {
                $this->deleteImageFile($doctor->image);
                $data['image'] = null;
            }
        }

        $doctor->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor updated successfully.',
            'data' => $doctor,
        ]);
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        // Delete the associated image file
        $this->deleteImageFile($doctor->image);

        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully.',
        ]);
    }

    /**
     * Get distinct department names from all doctors.
     */
    public function departments(): JsonResponse
    {
        $departments = Doctor::query()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->orderBy('department')
            ->pluck('department')
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'data' => $departments,
        ]);
    }

    /**
     * Upload an image file to the public storage and return the URL path.
     */
    private function uploadImage(\Illuminate\Http\UploadedFile $file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store in storage/app/public/doctors/
        $path = $file->storeAs('public/' . self::IMAGE_PATH, $filename);

        // Return the URL-accessible path
        return Storage::url($path);
    }

    /**
     * Delete an image file from storage if it exists and is not an external URL.
     */
    private function deleteImageFile(?string $imagePath): void
    {
        if (empty($imagePath)) {
            return;
        }

        // Only delete files stored in our managed storage (not external URLs)
        if (str_starts_with($imagePath, '/storage/')) {
            $relativePath = 'public/' . self::IMAGE_PATH . '/' . basename($imagePath);
            if (Storage::exists($relativePath)) {
                Storage::delete($relativePath);
            }
        }
    }
}
