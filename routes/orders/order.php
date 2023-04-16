<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
        Route::get('/get-all-hotel-order', [App\Http\Controllers\OrderController::class, 'getAllHotelOrder'])
                ->name('getAllHotelOrder');

        Route::get('/show-hotel-order/{order_id}', [App\Http\Controllers\OrderController::class, 'showHotelOrder'])
                ->name('showHotelOrder');
        
        Route::post('/create-hotel-order', [App\Http\Controllers\OrderController::class, 'createHotelOrder'])
                ->name('createHotelOrder');

        Route::post('/unpaid-hotel-cancel/{order_id}', [App\Http\Controllers\OrderController::class, 'unpaidHotelCancel'])
                ->name('unpaidHotelCancel');

        Route::get('/orders-need-review', [App\Http\Controllers\OrderController::class, 'ordersNeedReview'])
                ->name('ordersNeedReview');
});
