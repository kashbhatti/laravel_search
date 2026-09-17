<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/search', SearchController::class)
    ->middleware('throttle:60,1')
    ->name('search');
