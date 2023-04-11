<?php

use Illuminate\Support\Facades\Route;

//admin hotel
Route::group(['prefix' => 'hotels', 'as' => 'hotels.'], function() {
    Route::get('/', [App\Http\Controllers\HotelController::class, 'index']) 
            ->name('viewAllHotel');
    
    Route::get('/show-one/{hotel_id}', [App\Http\Controllers\HotelController::class, 'showOneHotel']) 
            ->name('showOneHotel');
    
    Route::delete('/delete/{hotel_id}', [App\Http\Controllers\HotelController::class, 'deleteHotel']) 
            ->name('deleteHotel');
});

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::get('/', [App\Http\Controllers\HotelController::class, 'showMe'])
        -> name('show');

    Route::post('/', [App\Http\Controllers\HotelController::class, 'createMe'])
        -> name('create');

    Route::put('/', [App\Http\Controllers\HotelController::class, 'updateMe'])
        -> name('update');

    Route::patch('/', [App\Http\Controllers\HotelController::class, 'updateMe'])
        -> name('update');

    Route::delete('/', [App\Http\Controllers\HotelController::class, 'destroyMe'])
        -> name('delete');
});



