<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AppointmentController,
    BannerController,
    DoctorController,
    NotificationController,
    OfferController,
    SpecialityController,
    UserController,
    AuthController};

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/banners', [BannerController::class, 'index']);
    Route::post('/banners', [BannerController::class, 'store']);


    Route::apiResource('specialities', SpecialityController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('offers', OfferController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('appointments', AppointmentController::class);

    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
});
