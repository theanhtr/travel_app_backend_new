<?php

use Illuminate\Support\Facades\Route;

//user info
Route::group(['prefix' => 'user-information', 'as' => 'user-information.'], function() {
    Route::get('/', [App\Http\Controllers\UserInformationController::class, 'index']) -> name('showAll');
    Route::post('/', [App\Http\Controllers\UserInformationController::class, 'store']) -> name('create');
    Route::put('/', [App\Http\Controllers\UserInformationController::class, 'update']) -> name('update');
    Route::patch('/', [App\Http\Controllers\UserInformationController::class, 'update']) -> name('update');
    Route::delete('/', [App\Http\Controllers\UserInformationController::class, 'destroy']) -> name('delete');
});

Route::group(['prefix' => 'my-information', 'as' => 'my-information.'], function() {
    Route::get('/', [App\Http\Controllers\UserInformationController::class, 'showMe']) -> name('show');
    Route::post('/', [App\Http\Controllers\UserInformationController::class, 'createMe']) -> name('create');
    Route::post('/change', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('update'); 
    Route::delete('/', [App\Http\Controllers\UserInformationController::class, 'destroyMe']) -> name('delete');

    
    //my-avatar
    Route::group(['prefix' => 'avatar', 'as' => 'avatar.'], function() {
        Route::get('/', [App\Http\Controllers\ImageController::class, 'showMyAvatar']) 
                ->name('show');

        Route::post('/', [App\Http\Controllers\ImageController::class, 'uploadMyAvatar']) 
                ->name('upload');
        
        Route::delete('/', [App\Http\Controllers\ImageController::class, 'deleteMyAvatar']) 
                ->name('delete');
    });
});