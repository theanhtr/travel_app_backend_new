<?php

use Illuminate\Support\Facades\Route;

//user info
Route::apiResource('/user-information', App\Http\Controllers\UserInformationController::class);
Route::get('/my-information', [App\Http\Controllers\UserInformationController::class, 'showMe']) -> name('my-information.show');
Route::put('/my-information', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('my-information.update');
Route::patch('/my-information', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('my-information.update');
Route::delete('/my-information', [App\Http\Controllers\UserInformationController::class, 'destroyMe']) -> name('my-information.delete');