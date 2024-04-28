<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // CRUD routes for the Link model
    Route::apiResource('links', LinkController::class);
});

// This is the route that will be used to redirect the user
// Links should be shareable and public, so no authentication is required
Route::get('{link_id}', [LinkController::class, 'show'])
    ->name('links.show');
