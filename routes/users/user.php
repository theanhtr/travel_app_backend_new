<?php

use Illuminate\Support\Facades\Route;

//user account
Route::get('/users', [App\Http\Controllers\UserController::class, 'index']) 
        ->name('viewAllUser');

Route::post('/user/create-new-user', [App\Http\Controllers\UserController::class, 'createNewUser']) 
        ->name('createNewUser');

Route::post('/user/show-one-user', [App\Http\Controllers\UserController::class, 'showOneUser']) 
        ->name('showOneUser');

Route::delete('/user/delete-user', [App\Http\Controllers\UserController::class, 'deleteUser']) 
        ->name('deleteUser');

Route::patch('/user/change-role', [App\Http\Controllers\UserController::class, 'changeRole']) 
        ->name('changeRole');

//user info
Route::apiResource('/user-information', App\Http\Controllers\UserInformationController::class);
Route::get('/my-information', [App\Http\Controllers\UserInformationController::class, 'showMe']) -> name('my-information.show');
Route::put('/my-information', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('my-information.update');
Route::patch('/my-information', [App\Http\Controllers\UserInformationController::class, 'updateMe']) -> name('my-information.update');
Route::delete('/my-information', [App\Http\Controllers\UserInformationController::class, 'destroyMe']) -> name('my-information.delete');