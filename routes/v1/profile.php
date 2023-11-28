<?php

use App\Http\Controllers\V1\ProfileController;

Route::controller(ProfileController::class)->group(function () {
    Route::name('profiles.')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('/profiles/{profile}/follows', 'follow')->name('follow');
            Route::put('/profiles/{profile}', 'update')->name('update');
            Route::delete('/profiles/{profile}/follows', 'unfollow')->name('unfollow');
        });

        Route::get('/profiles/{profile}', 'show')->name('get');
        Route::get('/profiles/{profile}/followers', 'followers')->name('followers');
        Route::get('/profiles/{profile}/following', 'following')->name('following');
    });
});
