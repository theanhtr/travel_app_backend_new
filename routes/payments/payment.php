<?php

use Illuminate\Support\Facades\Route;

Route::post('/payment/zalopay-callback', [App\Http\Controllers\PaymentController::class, 'zaloPayCallBack'])
    -> name('zaloPayCallBack');


   




