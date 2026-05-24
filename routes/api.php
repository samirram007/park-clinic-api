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
    Route::delete('/contacts/{contact}', [\App\Http\Controllers\Api\Admin\ContactController::class, 'destroy']);
});


