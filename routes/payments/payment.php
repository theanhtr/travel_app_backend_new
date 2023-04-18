<?php

use Illuminate\Support\Facades\Route;

Route::post('/payment/payment-server-callback', [App\Http\Controllers\PaymentController::class, 'paymentServerCallback'])
    -> name('paymentServerCallback');

Route::post('/payment/single-charge', [App\Http\Controllers\PaymentController::class, 'singleCharge'])
    -> name('singleCharge');    


   




