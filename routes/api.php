<?php

use App\Http\Controllers\System\Auth\AuthController;
use App\Http\Controllers\System\Auth\PasswordController;
use App\Http\Controllers\System\Auth\ProfileContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Auth Routes
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/send-otp', [PasswordController::class, 'sendResetCode']);
Route::post('auth/verify-otp', [PasswordController::class, 'verifyCode']);
Route::post('auth/reset-password', [PasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    // Profile Routes
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileContoller::class, 'me']);
        Route::put('update', [ProfileContoller::class, 'updateProfile']);
    });
});
