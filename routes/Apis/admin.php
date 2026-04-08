<?php

use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\SpecialityController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('specialities', SpecialityController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('offers', OfferController::class);
    Route::apiResource('users', UserController::class);
});
