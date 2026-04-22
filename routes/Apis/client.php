<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\{AppointmentController,
    AuthController,
    DoctorController,
    FavouriteController,
    NotificationController,
    OfferController,
    PasswordResetController,
    ProfileController,
    RatingController,
    SpecialityController,
    StripeController,
    StripeWebhookController};

// Auth
Route::middleware('guest:client')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('/verify-register', [AuthController::class, 'verifyRegister']);
    Route::post('login', [AuthController::class, 'login']);
});

// Password Reset
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/verifyToken', [PasswordResetController::class, 'verifyToken']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

// Public Data (Guest Access)
Route::get('specialities', [SpecialityController::class, 'index']);

Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index']);
    Route::get('/search', [DoctorController::class, 'search']);
    Route::get('/speciality/{specialityId}', [DoctorController::class, 'bySpeciality']);
    Route::get('/{id}', [DoctorController::class, 'show']);
});

Route::get('offers', [OfferController::class, 'index']);

Route::middleware('auth:client')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/show-profile', [ProfileController::class, 'show']);
        Route::post('/update-profile', [ProfileController::class, 'update']);
        Route::post('/change-email', [ProfileController::class, 'changeEmail']);
        Route::post('/change-phone', [ProfileController::class, 'changePhone']);
    });

    // User Features
    Route::apiResource('favourites', FavouriteController::class);
    Route::apiResource('ratings', RatingController::class);

    Route::apiResource('appointments', AppointmentController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::get('/notifications', [NotificationController::class, 'index']);

    // Payments
    Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);
    Route::post('/confirm-payment', [StripeController::class, 'confirmPayment']);

});


Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
