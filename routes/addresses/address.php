<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'addresses', 'as' => 'addresses.'], function() {
    Route::get('/provinces', [App\Http\Controllers\AddressController::class, 'showProvinces']) 
        ->name('showProvinces');

    Route::get('/{province_id}/districts', [App\Http\Controllers\AddressController::class, 'showDistricts']) 
        ->name('showDistricts');

    Route::get('{district_id}/sub-districts', [App\Http\Controllers\AddressController::class, 'showSubDistricts']) 
        ->name('showSubDistricts');
});

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::group(['prefix' => 'address', 'as' => 'address.'], function() {
        Route::get('/', [App\Http\Controllers\AddressController::class, 'showMyHotelAddress']) 
            ->name('showMyHotelAddress');
    });
});



