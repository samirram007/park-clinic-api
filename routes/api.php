<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/clear', function (Request $request) {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return response()->json(['message' => 'Cache cleared']);
});

Route::get('/mail-test', function () {
    Mail::raw('Laravel Mail Test', function ($message) {
        $message->to('samirram007@gmail.com')
            ->subject('Test Email');
    });

    return 'Mail Sent';
})->middleware('jwt.cookies');

Route::post('/contact', \App\Http\Controllers\Api\ContactController::class);
Route::post('/career/apply', [\App\Http\Controllers\Api\CareerController::class, 'apply']);
Route::get('/career/jobs', [\App\Http\Controllers\Api\CareerJobController::class, 'index']);

Route::get('/doctors', [\App\Http\Controllers\Api\DoctorController::class, 'index']);
Route::get('/doctors/{id}', [\App\Http\Controllers\Api\DoctorController::class, 'show']);
Route::get('/doctors/{id}/image', [\App\Http\Controllers\Api\DoctorController::class, 'image']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::middleware('jwt.cookies')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::post('/refresh', [\App\Http\Controllers\Api\AuthController::class, 'refresh']);
        Route::get('/profile', [\App\Http\Controllers\Api\AuthController::class, 'user']);
        Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'user']);
        Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'user']);
    });
});

Route::prefix('admin')->middleware('jwt.cookies')->group(function () {
    Route::get('/contacts', [\App\Http\Controllers\Api\Admin\ContactController::class, 'index']);
    Route::get('/contacts/{contact}', [\App\Http\Controllers\Api\Admin\ContactController::class, 'show']);
    Route::patch('/contacts/{contact}/read', [\App\Http\Controllers\Api\Admin\ContactController::class, 'markAsRead']);
    Route::patch('/contacts/{contact}/unread', [\App\Http\Controllers\Api\Admin\ContactController::class, 'markAsUnread']);
    Route::patch('/contacts/{contact}/important', [\App\Http\Controllers\Api\Admin\ContactController::class, 'toggleImportant']);
    Route::post('/contacts/{contact}/reply', [\App\Http\Controllers\Api\Admin\ContactController::class, 'reply']);
    Route::delete('/contacts/{contact}', [\App\Http\Controllers\Api\Admin\ContactController::class, 'destroy']);

    Route::get('/doctors', [\App\Http\Controllers\Api\Admin\DoctorController::class, 'index']);
    Route::post('/doctors', [\App\Http\Controllers\Api\Admin\DoctorController::class, 'store']);
    Route::get('/doctors/{doctor}', [\App\Http\Controllers\Api\Admin\DoctorController::class, 'show']);
    Route::put('/doctors/{doctor}', [\App\Http\Controllers\Api\Admin\DoctorController::class, 'update']);
    Route::delete('/doctors/{doctor}', [\App\Http\Controllers\Api\Admin\DoctorController::class, 'destroy']);

    Route::get('/job-posts', [\App\Http\Controllers\Api\Admin\JobPostController::class, 'index']);
    Route::post('/job-posts', [\App\Http\Controllers\Api\Admin\JobPostController::class, 'store']);
    Route::get('/job-posts/{jobPost}', [\App\Http\Controllers\Api\Admin\JobPostController::class, 'show']);
    Route::put('/job-posts/{jobPost}', [\App\Http\Controllers\Api\Admin\JobPostController::class, 'update']);
    Route::delete('/job-posts/{jobPost}', [\App\Http\Controllers\Api\Admin\JobPostController::class, 'destroy']);

    Route::get('/career-applications', [\App\Http\Controllers\Api\Admin\CareerApplicationController::class, 'index']);
    Route::get('/career-applications/{careerApplication}', [\App\Http\Controllers\Api\Admin\CareerApplicationController::class, 'show']);
    Route::delete('/career-applications/{careerApplication}', [\App\Http\Controllers\Api\Admin\CareerApplicationController::class, 'destroy']);
});


