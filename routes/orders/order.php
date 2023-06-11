<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
        Route::get('/get-all-hotel-order', [App\Http\Controllers\OrderController::class, 'getAllHotelOrder'])
                ->name('getAllHotelOrder');

        Route::get('/check-need-review', [App\Http\Controllers\OrderController::class, 'checkNeedReview'])
                ->name('checkNeedReview');

        Route::get('/show-hotel-order/{order_id}', [App\Http\Controllers\OrderController::class, 'showHotelOrder'])
                ->name('showHotelOrder');
        
        Route::post('/create-hotel-order', [App\Http\Controllers\OrderController::class, 'createHotelOrder'])
                ->name('createHotelOrder');

        Route::post('/unpaid-hotel-cancel/{order_id}', [App\Http\Controllers\OrderController::class, 'unpaidHotelCancel'])
                ->name('unpaidHotelCancel');

        Route::get('/orders-need-review', [App\Http\Controllers\OrderController::class, 'ordersNeedReview'])
                ->name('ordersNeedReview');

        Route::post('/payment', [App\Http\Controllers\OrderController::class, 'payment'])
                -> name('payment'); 
        
        Route::post('/payment-client', [App\Http\Controllers\OrderController::class, 'paymentClient'])
                -> name('payment-client'); 
                
        Route::post('/paid-hotel-cancel/{order_id}', [App\Http\Controllers\OrderController::class, 'paidHotelCancel'])
                ->name('paidHotelCancel');

        Route::get('/statistic', [App\Http\Controllers\OrderController::class, 'orderStatistic'])
        ->name('orderStatistic');
});