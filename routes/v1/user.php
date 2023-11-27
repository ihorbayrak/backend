<?php

use App\Http\Controllers\V1\UserController;

Route::controller(UserController::class)->group(function () {
    Route::name('users.')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::put('/user', 'update')->name('update');
            Route::patch('/user/change-password', 'changePassword')->name('change-password');
            Route::delete('/user', 'destroy')->name('deactivate');
        });

        Route::post('/user/{user}/restore', 'restore')->name('restore');
    });
});
