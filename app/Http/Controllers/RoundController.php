<?php

namespace App\Http\Controllers;

use App\Http\Resources\Round as RoundResource;
use App\Models\Room;
use App\Models\Round;

use App\Services\Spotify\Facades\Spotify;

use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Round
     */
    public function store(Request $request, Room $room)
    {
        $this->authorize('create', [Round::class, $room]);

        $response = Spotify::playlist(
            $room->spotify_playlist_uri,
            $request->user()->spotify_access_token
        );

        $track = collect($response['tracks']['items'])->map->track->random();

        $round = $room->rounds()->create([
            'spotify_track_uri' => $track['uri'],
            'spotify_track_name' => $track['name'],
        ]);

        return new RoundResource($round);
    }
}
