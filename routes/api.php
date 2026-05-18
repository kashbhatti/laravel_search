<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::post('/search', SearchController::class)->middleware('auth:sanctum');
Route::post('/login', AuthController::class);
