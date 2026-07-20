<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Versioned API routes. All routes are prefixed with /api/v1.
| Authentication via Sanctum tokens.
|
*/

Route::prefix('v1')->group(function () {

    // Public API routes (no auth required)
    Route::get('/health', fn () => response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
    ]));

    // ── Auth Routes ─────────────────────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::post('/register', [\App\Http\Controllers\Api\V1\Auth\RegisteredUserController::class, 'store'])
            ->middleware('guest')
            ->name('api.v1.auth.register');

        Route::post('/login', [\App\Http\Controllers\Api\V1\Auth\AuthenticatedSessionController::class, 'store'])
            ->middleware('guest')
            ->name('api.v1.auth.login');

        Route::post('/logout', [\App\Http\Controllers\Api\V1\Auth\AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth:sanctum')
            ->name('api.v1.auth.logout');
    });

    // ── Protected Routes ────────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Current User
        Route::get('/user', [\App\Http\Controllers\Api\V1\Auth\AuthenticatedSessionController::class, 'show'])
            ->name('api.v1.user');

        // Profile
        Route::put('/profile', [\App\Http\Controllers\Api\V1\ProfileController::class, 'update'])
            ->name('api.v1.profile.update');

        // Categories CRUD
        Route::apiResource('categories', \App\Http\Controllers\Api\V1\CategoryController::class);
    });
});
