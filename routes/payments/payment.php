<?php

use App\Http\Controllers\PaymentAccountController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'payments', 'as' => 'payments.'], function() {
    Route::get('account', [PaymentAccountController::class, 'show']);  
    Route::post('account', [PaymentAccountController::class, 'store']);  
    Route::put('account', [PaymentAccountController::class, 'update']);  
    Route::patch('account', [PaymentAccountController::class, 'update']);  
    Route::delete('account', [PaymentAccountController::class, 'destroy']);  
});
   




