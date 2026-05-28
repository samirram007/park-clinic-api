<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// composer update
Route::get('/composer-update', function () {
    exec('composer update');
    return 'Composer update executed';
});
