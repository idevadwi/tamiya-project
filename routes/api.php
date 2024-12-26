<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\RacerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentParticipantController;
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

//cards
Route::resource('cards', CardController::class);
Route::get('cards/code/{card_code}', [CardController::class, 'getByCardCode']);
Route::get('cards/racer/{racer_id}', [CardController::class, 'getByRacerId']);

//racers
Route::resource('racers', RacerController::class);
Route::get('racers/team/{team_id}', [RacerController::class, 'getByTeamId']);

//teams
Route::resource('teams', TeamController::class);

//tournament participants
Route::resource('participants', TournamentParticipantController::class);
Route::get('tournaments/{tournament_id}/participants', [TournamentParticipantController::class, 'getParticipantsByTournamentId']);
