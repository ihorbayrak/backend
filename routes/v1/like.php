<?php

use App\Http\Controllers\V1\LikeController;

Route::controller(LikeController::class)->group(function () {
    Route::name('likes.')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('/posts/{post}/like', 'likePost')->name('like-post');
            Route::delete('/posts/{post}/like', 'unlikePost')->name('unlike-post');
            Route::post('/comments/{comment}/like', 'likeComment')->name('like-comment');
            Route::delete('/comments/{comment}/like', 'unlikeComment')->name('unlike-comment');
        });
    });
});
