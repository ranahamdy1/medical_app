<?php

use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\PasswordResetController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/verifyToken', [PasswordResetController::class, 'verifyToken']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);
