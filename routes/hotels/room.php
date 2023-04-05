<?php

use Illuminate\Support\Facades\Route;

//hotel manager -> room

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function() {
        Route::post('/', [App\Http\Controllers\RoomController::class, 'addRooms'])
            -> name('add');

        Route::post('/', [App\Http\Controllers\RoomController::class, 'changeAvailablity'])
            -> name('changeAvailablity');

        Route::delete('/{type_room_id}', [App\Http\Controllers\RoomController::class, 'deleteRoom'])
            -> name('delete');
    });
});



