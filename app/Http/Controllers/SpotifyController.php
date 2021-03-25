<?php

namespace App\Http\Controllers;

use App\Services\Spotify\Exceptions\LoginFailed;
use App\Services\Spotify\Facades\Spotify;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $response = response()->redirectTo($request->query('state'));

        $player = $request->user();

        try {
            $result = Spotify::authenticate($request->code);
        } catch (LoginFailed $e) {
            $response->with('error', $e->getMessage());
        }

        if (isset($result)) {
            $player->spotify_access_token = $result['access_token'];
            $player->spotify_token_type = $result['token_type'];
            $player->spotify_expires_at = now()->addSeconds($result['expires_in']);
            $player->spotify_refresh_token = $result['refresh_token'];
            $player->spotify_scope = $result['scope'];
            $player->save();
        }

        return $response;
    }
}
