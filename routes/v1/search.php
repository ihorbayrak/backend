<?php

use App\Http\Controllers\V1\SearchController;

Route::middleware('auth:api')->group(function () {
    Route::get('/search', SearchController::class)->name('search');
});
