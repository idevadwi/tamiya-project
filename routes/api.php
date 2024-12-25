<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TournamentController;

//Route::post('/users', [UserController::class, 'store']);
//Route::get('/users/{id}', [UserController::class, 'show']);
//
//// Protected routes (requires authentication)
//Route::middleware('auth:sanctum')->group(function () {
//    Route::put('/users/{id}', [UserController::class, 'update']);
//    Route::delete('/users/{id}', [UserController::class, 'destroy']);
//});

Route::resource('users', UserController::class);
Route::resource('tournaments', TournamentController::class);
