<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'likes', 'as' => 'likes.'], function() {
    Route::get('/hotels', [App\Http\Controllers\UserLikeController::class, 'getHotelsLike'])
        ->name('getHotelsLike');

    Route::post('/hotel/{hotel_id}', [App\Http\Controllers\UserLikeController::class, 'likeHotel'])
        ->name('likeHotel');

    Route::post('/popular-destination/{popular_destination_id}', [App\Http\Controllers\UserLikeController::class, 'likePopularDestination'])
        ->name('likePopularDestination');
});
