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






