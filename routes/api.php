<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;

Route::get('places', [PlaceController::class, 'getAll']);
Route::post('places', [PlaceController::class, 'postOne']);
Route::put('places/{id}', [PlaceController::class, 'putchOne']);
Route::delete('places/{id}', [PlaceController::class, 'deleteOne']);