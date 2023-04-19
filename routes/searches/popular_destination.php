<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'popular-destination', 'as' => 'populars-destination.'], function() {
    Route::get('/', [App\Http\Controllers\PopularDestinationController::class, 'getAll'])
        ->name('getAll');
});
