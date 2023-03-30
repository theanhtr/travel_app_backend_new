<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function() {
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticationController::class, 'login'])
        ->name('login');

    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
        ->name('register');

    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgotPassword'])
        ->name('forgotPassword');

    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'viewResetPassword'])
        ->name('viewResetPassword');

    Route::post('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])
        ->name('resetPassword');

    Route::get('/email-confirm/{user_id}/{email}', [App\Http\Controllers\Auth\RegisterController::class, 'confirmedEmail'])
        ->name('confirmedEmail');

    Route::post('/re-send-email-confirm', [App\Http\Controllers\Auth\RegisterController::class, 'reSendEmailConfirm'])
        ->name('reSendEmailConfirm');
});