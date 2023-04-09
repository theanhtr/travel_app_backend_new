<?php

use Illuminate\Support\Facades\Route;

//user account
Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index']) 
                ->name('viewAllUser');

        Route::post('/get-by-email', [App\Http\Controllers\UserController::class, 'showOneUser']) 
                        ->name('showOneUser');
                        
        Route::post('/create-new-user', [App\Http\Controllers\UserController::class, 'createNewUser']) 
                ->name('createNewUser');

        Route::delete('/delete-user', [App\Http\Controllers\UserController::class, 'deleteUser']) 
                ->name('deleteUser');

        Route::get('/get-role', [App\Http\Controllers\UserController::class, 'getRole']) 
                ->name('getRole');

        Route::patch('/change-role', [App\Http\Controllers\UserController::class, 'changeRole']) 
                ->name('changeRole');
});