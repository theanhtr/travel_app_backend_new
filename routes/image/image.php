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

        Route::post('/upload', [App\Http\Controllers\ImageController::class, 'upload']) 
                ->name('upload');

        Route::post('/upload-mutiple-image', [App\Http\Controllers\ImageController::class, 'uploadMutipleImage']) 
                ->name('uploadMutipleImage');
});

Route::group(['prefix' => 'my-avatar', 'as' => 'my-avatar.'], function() {
        Route::get('/', [App\Http\Controllers\ImageController::class, 'showMyAvatar']) 
                ->name('show');

        Route::post('/', [App\Http\Controllers\ImageController::class, 'uploadMyAvatar']) 
                ->name('upload');
        
        Route::delete('/', [App\Http\Controllers\ImageController::class, 'deleteMyAvatar']) 
                ->name('delete');
});




