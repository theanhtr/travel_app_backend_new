<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'payments', 'as' => 'payments.'], function() {
    Route::post('/payment-server-callback', [App\Http\Controllers\PaymentController::class, 'paymentServerCallback'])
        -> name('paymentServerCallback');

      
});
   




