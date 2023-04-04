<?php

use Illuminate\Support\Facades\Route;

//hotel manager -> type room
// Route::group(['prefix' => 'type-rooms', 'as' => 'type-rooms.'], function() {
//     Route::get('/', [App\Http\Controllers\TypeRoomController::class, 'index']) 
//             ->name('viewAllHotel');
    
//     Route::get('/show-one-hotel/{hotel_id}', [App\Http\Controllers\TypeRoomController::class, 'showOneHotel']) 
//             ->name('showOneHotel');
    
//     Route::delete('/delete-hotel/{hotel_id}', [App\Http\Controllers\TypeRoomController::class, 'deleteHotel']) 
//             ->name('deleteHotel');
// });

Route::group(['prefix' => 'my-hotel', 'as' => 'my-hotel.'], function() {
    Route::group(['prefix' => 'type-rooms', 'as' => 'type-rooms.'], function() {
        Route::get('/', [App\Http\Controllers\TypeRoomController::class, 'showAllTypeRoom'])
            -> name('show');
        
        Route::get('/{type_room_id}', [App\Http\Controllers\TypeRoomController::class, 'showTypeRoom'])
            -> name('show');

        Route::post('/', [App\Http\Controllers\TypeRoomController::class, 'addTypeRoom'])
            -> name('add');

        Route::put('/{type_room_id}', [App\Http\Controllers\TypeRoomController::class, 'updateTypeRoom'])
            -> name('update');

        Route::patch('/{type_room_id}', [App\Http\Controllers\TypeRoomController::class, 'updateTypeRoom'])
            -> name('update');

        Route::delete('/{type_room_id}', [App\Http\Controllers\TypeRoomController::class, 'deleteTypeRoom'])
            -> name('delete');

        Route::group(['prefix' => '{type_room_id}/amenities', 'as' => 'amenities.'], function() {
            Route::post('/', [App\Http\Controllers\TypeRoomController::class, 'addAmenities'])
                -> name('add');
    
            Route::delete('/', [App\Http\Controllers\TypeRoomController::class, 'deleteAmenities'])
                -> name('delete');
        });
    });
});



