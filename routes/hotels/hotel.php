<?php

use Illuminate\Support\Facades\Route;

//admin hotel
Route::group(['prefix' => 'hotels', 'as' => 'hotels.'], function() {
    Route::get('/', [App\Http\Controllers\HotelController::class, 'index']) 
            ->name('viewAllHotel');
    
    Route::get('/show-one-hotel/{hotel_id}', [App\Http\Controllers\HotelController::class, 'showOneHotel']) 
            ->name('showOneHotel');
    
    Route::delete('/delete-hotel/{hotel_id}', [App\Http\Controllers\HotelController::class, 'deleteHotel']) 
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

    Route::group(['prefix' => 'amenities', 'as' => 'amenities.'], function() {
        Route::get('/', [App\Http\Controllers\HotelController::class, 'showAmenities'])
            -> name('show');

        Route::post('/', [App\Http\Controllers\HotelController::class, 'addAmenities'])
            -> name('add');

        Route::delete('/', [App\Http\Controllers\HotelController::class, 'deleteAmenities'])
            -> name('delete');
    });

    Route::group(['prefix' => 'images', 'as' => 'images.'], function() {
        Route::get('/', [App\Http\Controllers\ImageController::class, 'showHotelImages']) 
                ->name('show');

        Route::post('/', [App\Http\Controllers\ImageController::class, 'uploadHotelImages']) 
                ->name('upload');
        
        Route::delete('/', [App\Http\Controllers\ImageController::class, 'deleteHotelImages']) 
                ->name('delete');
    });
});



