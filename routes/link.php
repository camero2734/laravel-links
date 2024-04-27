<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('links/create', [LinkController::class, 'store'])
        ->name('link.create');
    Route::get('links/index', [LinkController::class, 'index'])
        ->name('link.index');
});
