<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GuestController;


Route::get('/guests', [GuestController::class, 'guestsList']);
Route::get('/guests/{id}', [GuestController::class, 'guestsEdit']);
Route::post('/guests/save', [GuestController::class, 'guestsSave']);
Route::post('/guests/update/{id}', [GuestController::class, 'guestsUpdate']);
Route::delete('/guests/delete/{id}', [GuestController::class, 'guestsDelete']);
