<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::get('/', function () {
    return view('welcome');
});

// composer update
Route::get('/composer-update', function () {
    exec('composer update');
    return 'Composer update executed';
});

Route::get('/storage-link', function () {
    try {
        Artisan::call('storage:link');

        return [
            'success' => true,
            'message' => Artisan::output(),
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage(),
        ];
    }
});
