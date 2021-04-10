<?php

namespace App\Http\Controllers;

use App\Http\Resources\Round as RoundResource;
use App\Models\Guess;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Room  $room
     * @param  \App\Models\Round  $round
     * @return \App\Http\Resources\Round
     */
    public function update(Room $room, Round $round)
    {
        $this->authorize('update', [$round, $room]);

        // Compute scores for all players
        $guesses = $round->guesses()
            ->correct()
            ->latest()
            ->get();

        $playerCount = $guesses->pluck('player_id')->count();

        // Decide how many points are awarded based on how many players participated.
        $points = 100 * $playerCount;

        // Compute a guess quality - faster means better
        $guesses = $guesses->map(function (Guess $guess) use ($round) {
            $guess->quality = $guess->created_at->diffInSeconds($round->playback_at);

            return $guess;
        });

        $quality = $guesses->reduce(fn (int $carry, Guess $guess) => $guess->quality + $carry, 0);

        foreach ($guesses as $guess) {
            $guess->player->increment('score', $guess->quality * ($points / $quality));
        }

        return new RoundResource($round);
    }
}
