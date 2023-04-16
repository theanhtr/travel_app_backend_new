<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function() {
        Route::post('/create-review', [App\Http\Controllers\ReviewController::class, 'createReview'])
                ->name('createReview');

        Route::get('/all-hotel-review/{hotel_id}', [App\Http\Controllers\ReviewController::class, 'allHotelReview'])
                ->name('allHotelReview');
                
        // Route::get('/show-hotel-order/{order_id}', [App\Http\Controllers\ReviewController::class, 'showHotelOrder'])
        //         ->name('showHotelOrder');
        
        // Route::post('/unpaid-hotel-cancel/{order_id}', [App\Http\Controllers\ReviewController::class, 'unpaidHotelCancel'])
        //         ->name('unpaidHotelCancel');
});
