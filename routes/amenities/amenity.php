<?php

use Illuminate\Support\Facades\Route;

//admin amenities
Route::apiResource('/amenities', App\Http\Controllers\AmenityController::class);

Route::group(['prefix' => 'amenities', 'as' => 'amenities.'], function() {
    // Route::get('/my-hotel-address', [App\Http\Controllers\AddressController::class, 'showMyHotelAddress']) 
    //         ->name('showMyHotelAddress');
});
