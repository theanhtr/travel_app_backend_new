<?php

use Illuminate\Support\Facades\Route;

//admin hotel
Route::group(['prefix' => 'addresses', 'as' => 'addresses.'], function() {
    Route::get('/my-hotel-address', [App\Http\Controllers\AddressController::class, 'showMyHotelAddress']) 
            ->name('showMyHotelAddress');
});



