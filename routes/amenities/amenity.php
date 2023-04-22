<?php

use Illuminate\Support\Facades\Route;

//admin amenities
Route::apiResource('/amenities', App\Http\Controllers\AmenityController::class);

Route::get('/hotel-amenities', [App\Http\Controllers\AmenityController::class, 'showAmenitiesOfHotel'])
    -> name('showAmenitiesOfHotel');

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::group(['prefix' => 'amenities', 'as' => 'amenities.'], function() {
        Route::get('/', [App\Http\Controllers\HotelController::class, 'showAmenities'])
            -> name('show');

        Route::post('/', [App\Http\Controllers\HotelController::class, 'addAmenities'])
            -> name('add');

        Route::delete('/', [App\Http\Controllers\HotelController::class, 'deleteAmenities'])
            -> name('delete');
    });
});




