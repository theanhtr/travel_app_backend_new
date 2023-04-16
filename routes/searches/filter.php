<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'filters', 'as' => 'filters.'], function() {
    Route::get('/hotel-sort-by', [App\Http\Controllers\FilterController::class, 'getHotelSortBy'])
        ->name('getHotelSortBy');

    Route::post('/hotels', [App\Http\Controllers\FilterController::class, 'filterHotels'])
        ->name('filterHotels');
        
    Route::get('/review-sort-by', [App\Http\Controllers\FilterController::class, 'getReviewSortBy'])
        ->name('getReviewSortBy');

    Route::post('/reviews', [App\Http\Controllers\FilterController::class, 'filterReviews'])
        ->name('filterReviews');
});
