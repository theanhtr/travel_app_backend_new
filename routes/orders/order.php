<?php

use Illuminate\Support\Facades\Route;

//file
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
        Route::post('/create-hotel-order', [App\Http\Controllers\OrderController::class, 'createHotelOrder'])
                ->name('createHotelOrder');
});
