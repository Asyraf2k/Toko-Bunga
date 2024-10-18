<?php

use App\Http\Controllers\Api\PersonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route dengan middleware auth:sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Menggunakan resource route untuk PersonController
Route::resource('/person', PersonController::class);
