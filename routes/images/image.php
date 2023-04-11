<?php

use Illuminate\Support\Facades\Route;

//file
Route::group(['prefix' => 'images', 'as' => 'images.'], function() {
        Route::get('', [App\Http\Controllers\ImageController::class, 'index'])
                ->name('images');

        Route::get('/{image_id}', [App\Http\Controllers\ImageController::class, 'show']) 
                ->name('show');

        Route::delete('/{image_id}', [App\Http\Controllers\ImageController::class, 'destroy']) 
                ->name('destroy');
});

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::group(['prefix' => 'images', 'as' => 'images.'], function() {
        Route::get('/', [App\Http\Controllers\ImageController::class, 'showHotelImages']) 
                ->name('show');

        Route::post('/', [App\Http\Controllers\ImageController::class, 'uploadHotelImages']) 
                ->name('upload');
        
        Route::delete('/', [App\Http\Controllers\ImageController::class, 'deleteHotelImages']) 
                ->name('delete');
    });

    Route::group(['prefix' => 'type-rooms/{type_room_id}', 'as' => 'type-rooms.'], function() {
        Route::group(['prefix' => 'images', 'as' => 'images.'], function() {
            Route::get('/', [App\Http\Controllers\ImageController::class, 'showTypeRoomImages']) 
                    ->name('show');
    
            Route::post('/', [App\Http\Controllers\ImageController::class, 'uploadTypeRoomImages']) 
                    ->name('upload');
            
            Route::delete('/', [App\Http\Controllers\ImageController::class, 'deleteTypeRoomImages']) 
                    ->name('delete');
        });
    });
});