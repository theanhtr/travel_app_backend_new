<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'searches', 'as' => 'searches.'], function() {
    Route::post('/hotels', [App\Http\Controllers\SearchController::class, 'searchHotels'])
        ->name('searchHotels');

    Route::get('/hotels/{hotel_id}', [App\Http\Controllers\SearchController::class, 'getHotelSearch'])
        ->name('getHotelSearch');

    Route::post('/type-rooms', [App\Http\Controllers\SearchController::class, 'searchTypeRooms'])
        ->name('searchTypeRooms');

    Route::post('/hotels-at-popular-destination', [App\Http\Controllers\SearchController::class, 'searchHotelsAtPopularDestination'])
        ->name('searchHotelsAtPopularDestination');
});
