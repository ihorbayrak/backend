<?php

use App\Http\Controllers\V1\CommentController;

Route::controller(CommentController::class)->group(function () {
    Route::name('comments.')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('/posts/{post}/comments', 'store')->name('create');
            Route::delete('/posts/{post}/comments/{comment}', 'destroy')->name('delete');
        });
        Route::get('/posts/{post}/comments', 'index')->name('all');
        Route::get('/posts/{post}/comments/{comment}', 'show')->name('show');
    });
});
