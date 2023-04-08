<?php

use Illuminate\Support\Facades\Route;

//hotel manager -> room

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function() {
        Route::post('/add-rooms', [App\Http\Controllers\RoomController::class, 'addRooms'])
            -> name('add');

        // Route::post('/delete-rooms', [App\Http\Controllers\RoomController::class, 'deleteRooms'])
        //     -> name('delete');

        Route::post('/change-availablity/{room_id}', [App\Http\Controllers\RoomController::class, 'changeAvailablity'])
            -> name('changeAvailablity');
    });
});



