<?php

use App\Http\Controllers\Client\AppointmentController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\DoctorController;
use App\Http\Controllers\Client\FavouriteController;
use App\Http\Controllers\Client\OfferController;
use App\Http\Controllers\Client\PasswordResetController;
use App\Http\Controllers\Client\RatingController;
use App\Http\Controllers\Client\SpecialityController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/verifyToken', [PasswordResetController::class, 'verifyToken']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::get('specialities', [SpecialityController::class, 'index']);

    Route::get('/doctors/search', [DoctorController::class, 'search']);
    Route::get('/doctors/speciality/{specialityId}', [DoctorController::class, 'bySpeciality']);
    Route::get('/doctors/{id}', [DoctorController::class, 'show']);
    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::apiResource('favourites', FavouriteController::class);
    Route::apiResource('ratings', RatingController::class);
    Route::get('offers', [OfferController::class, 'index']);
    Route::apiResource('appointments', AppointmentController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
});
