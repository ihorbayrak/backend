<?php

use App\Http\Controllers\V1\Auth\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/refresh', 'refresh')->name('refresh-token');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::put('/verify-email', 'verify')->name('verify-email');
    });
});
