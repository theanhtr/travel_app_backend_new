<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function() {
        Route::post('/create-review', [App\Http\Controllers\ReviewController::class, 'createReview'])
                ->name('createReview');

        Route::get('/all-hotel-review/{hotel_id}', [App\Http\Controllers\ReviewController::class, 'allHotelReview'])
                ->name('allHotelReview');
                
        Route::post('/like', [App\Http\Controllers\ReviewController::class, 'likesReviews'])
                ->name('likesReviews');
        
        Route::post('/report', [App\Http\Controllers\ReviewController::class, 'reportReviews'])
                ->name('reportReviews');
});
