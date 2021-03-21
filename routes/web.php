<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Http;
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

Route::get('callback/spotify', function () {

    $response = Http::withBasicAuth(config('services.spotify.client.id'), config('services.spotify.client.secret'))
        ->asForm()
        ->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'authorization_code',
            'code' => request()->query('code'),
            'redirect_uri' => route('callback.spotify'),
        ]);

    $player = auth()->user();

    $player->spotify_access_token = $response['access_token'];
    $player->spotify_token_type = $response['token_type'];
    $player->spotify_expires_at = now()->addSeconds($response['expires_in']);
    $player->spotify_refresh_token = $response['refresh_token'];
    $player->spotify_scope = $response['scope'];

    $player->save();

    return response()->redirectTo(request()->query('state'));
})->name('callback.spotify');

Route::middleware('response.json')->group(function () {
    Route::apiResource('players', PlayerController::class)->only('update');
});
