<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::apiResource('links', LinkController::class);

    Route::get('{link_id}', [LinkController::class, 'show'])
        ->name('links.show');
});
