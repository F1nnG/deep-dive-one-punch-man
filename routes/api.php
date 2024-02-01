<?php

use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\BattleController;
use App\Http\Controllers\Api\BattleRequestController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user/{user}', [UserController::class, 'show'])
    ->name('users.show');

Route::post('/request-battle', [BattleRequestController::class, 'create'])
    ->name('battle-request.create');

Route::get('/availabilities', [AvailabilityController::class, 'index'])
    ->name('availability.index');
Route::post('/availability/add', [AvailabilityController::class, 'create'])
    ->name('availability.create');

Route::get('/leaderboard', [StatisticsController::class, 'index'])
    ->name('statistics.index');
Route::get('/user/{user}/statistics', [StatisticsController::class, 'show'])
    ->name('statistics.show');

Route::get('/user/{user}/battles', [BattleController::class, 'index'])
    ->name('battles.index');
Route::get('/battle/{battle}', [BattleController::class, 'show'])
    ->name('battles.show');
