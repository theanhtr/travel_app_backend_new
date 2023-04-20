<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'messages', 'as' => 'messages.'], function() {
        Route::post('/send', [App\Http\Controllers\MessageController::class, 'sendMessage'])
                ->name('sendMessage');
        
        Route::get('/', [App\Http\Controllers\MessageController::class, 'getMessages'])
                ->name('getMessages');
});