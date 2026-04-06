<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', fn () => 'admin dashboard');

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
