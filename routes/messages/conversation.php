<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'conversations', 'as' => 'conversations.'], function() {
    Route::post('/create', [App\Http\Controllers\ConversationController::class, 'create'])
            ->name('create');
});