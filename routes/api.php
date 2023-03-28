<?php

use App\Http\Controllers\AuthenticationController;
use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([], function() {
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
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticationController::class, 'logout']) 
        ->name('logout');
    Route::apiResource('users', App\Http\Controllers\UserController::class);
});
