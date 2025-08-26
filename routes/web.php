<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect()->route('locations.index');
});
Route::resource('locations', LocationController::class);
