<?php

use Illuminate\Support\Facades\Route;

//file
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
        Route::get('', [App\Http\Controllers\OrderController::class, 'index'])
                ->name('images');

        Route::get('/{image_id}', [App\Http\Controllers\OrderController::class, 'show']) 
                ->name('show');

        Route::delete('/{image_id}', [App\Http\Controllers\OrderController::class, 'destroy']) 
                ->name('destroy');
});
