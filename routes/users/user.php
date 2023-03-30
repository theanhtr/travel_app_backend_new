<?php

use Illuminate\Support\Facades\Route;

//user account
Route::group(['prefix' => 'users', 'as' => 'users.'], function() {

Route::get('/', [App\Http\Controllers\UserController::class, 'index']) 
        ->name('viewAllUser');
        
Route::post('/create-new-user', [App\Http\Controllers\UserController::class, 'createNewUser']) 
        ->name('createNewUser');

Route::post('/show-one-user', [App\Http\Controllers\UserController::class, 'showOneUser']) 
        ->name('showOneUser');

Route::delete('/delete-user', [App\Http\Controllers\UserController::class, 'deleteUser']) 
        ->name('deleteUser');

Route::patch('/change-role', [App\Http\Controllers\UserController::class, 'changeRole']) 
        ->name('changeRole');
});