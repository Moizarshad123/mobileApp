<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::GET('blogs', [AuthController::class,'blogs']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::PUT('update-fcm-token', 'updateFcmToken');
        Route::PUT('update-user-location', 'updateUserLocation');
        Route::POST('change-password', 'changePassword');
        Route::POST('logout', 'logout');
    });
});


Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::POST('login', 'login');
        Route::POST('register', 'register');
        Route::POST('verify-token', 'verifyToken');
        Route::POST('resend-otp-token', 'resendOtpToken');
        Route::POST('forgot-password', 'forgotPassword');
        Route::PUT('set-password', 'setPassword');
        Route::GET('unauthenticated', 'unauthenticatedUser')->name('api.unauthenticated');
    });
});
