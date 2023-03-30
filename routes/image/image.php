<?php

use Illuminate\Support\Facades\Route;

//file
Route::post('/upload', [App\Http\Controllers\ImageController::class, 'upload']) 
        ->name('upload');

Route::post('/upload-mutiple-image', [App\Http\Controllers\ImageController::class, 'uploadMutipleImage']) 
        ->name('uploadMutipleImage');

