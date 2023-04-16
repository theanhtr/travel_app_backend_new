<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'filters', 'as' => 'filters.'], function() {
    Route::get('/hotel-filter-option', [App\Http\Controllers\FilterController::class, 'hotelFilterOption'])
        ->name('hotelFilterOption');

    Route::post('/hotels', [App\Http\Controllers\FilterController::class, 'filterHotels'])
        ->name('filterHotels');
        
    Route::get('/review-filter-option', [App\Http\Controllers\FilterController::class, 'reviewFilterOption'])
        ->name('reviewFilterOption');

    Route::post('/reviews', [App\Http\Controllers\FilterController::class, 'filterReviews'])
        ->name('filterReviews');
});
