<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Route::post('links/create', [LinkController::class, 'store'])
    //     ->name('link.create');
    // Route::get('links/index', [LinkController::class, 'index'])
    //     ->name('link.index');
    // Route::delete('links/{id}/destroy', [LinkController::class, 'destroy'])
    //     ->name('link.destroy');

    Route::apiResource('links', LinkController::class);
});
