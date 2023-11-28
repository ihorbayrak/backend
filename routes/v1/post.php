<?php

use App\Http\Controllers\V1\PostController;
use App\Http\Controllers\V1\RepostController;

Route::name('posts.')->group(function () {
    Route::controller(PostController::class)->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('/posts/feed', 'feed')->name('feed');
            Route::post('/posts', 'store')->name('create');
            Route::put('/posts/{post}', 'update')->name('update');
            Route::delete('/posts/{post}', 'destroy')->name('delete');
        });

        Route::get('/posts', 'list')->name('list');
        Route::get('/posts/{post}', 'show')->name('get');
    });

    Route::controller(RepostController::class)->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('/posts/{post}/repost', 'store')->name('repost');
            Route::delete('/posts/{post}/repost', 'destroy')->name('remove-repost');
        });
    });
});
