<?php

use Illuminate\Support\Facades\Route;

//user info
Route::apiResource('/user-information', App\Http\Controllers\UserInformationController::class);

Route::group(['prefix' => 'my-information', 'as' => 'my-information.'], function() {
    Route::get('/', [App\Http\Controllers\UserInformationController::class, 'showMe']) -> name('show');
    Route::put('/', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('update');
    Route::patch('/', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('update');
    Route::delete('/', [App\Http\Controllers\UserInformationController::class, 'destroyMe']) -> name('delete');
});