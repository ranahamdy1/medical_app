<?php

use App\Http\Controllers\Client\{
    AppointmentController,
    AuthController,
    DoctorController,
    FavouriteController,
    NotificationController,
    OfferController,
    PasswordResetController,
    RatingController,
    SpecialityController,
    StripeController,
    StripeWebhookController
};

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/verifyToken', [PasswordResetController::class, 'verifyToken']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::middleware('auth:client')->group(function () {

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

    Route::apiResource('appointments', AppointmentController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::get('/notifications', [NotificationController::class, 'index']);

    // stripe
    Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);
    Route::post('/confirm-payment', [StripeController::class, 'confirmPayment']);
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
