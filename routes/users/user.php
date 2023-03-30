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
