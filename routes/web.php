<?php

use App\Http\Controllers\GuessController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('rooms', RoomController::class)->only('store', 'show');

Route::middleware('auth:web')->group(function () {
    Route::get('callback/spotify', SpotifyController::class)->name('callback.spotify');

    Route::middleware('response.json')->group(function () {
        Route::apiResource('players', PlayerController::class)->only('update');

        Route::apiResource('rooms.rounds', RoundController::class)->only('store', 'update');
        Route::apiREsource('rounds.guesses', GuessController::class)->only('store');
    });
});
