<?php

use App\Http\Controllers\Api\v1\User\Events\EventController;
use App\Http\Controllers\Api\v1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('telegram', [UserController::class, 'handleTelegramAuth'])
            ->name('auth.telegram');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [UserController::class, 'getUser']);
        Route::get('events/today', [EventController::class, 'todayEvents']);
    });
});
