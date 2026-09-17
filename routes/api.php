<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::post('/search', SearchController::class)
    ->middleware('auth:sanctum', 'throttle:60,1')
    ->name('api.search');

Route::post('/login', AuthController::class)
    ->middleware('throttle:20,1')
    ->name('api.login');
