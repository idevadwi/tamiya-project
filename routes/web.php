<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user', UserController::class);

Route::get('/swagger', function () {
    return view('swagger-ui');
});

Route::resource('tournaments', TournamentController::class);
