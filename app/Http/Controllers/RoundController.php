<?php

namespace App\Http\Controllers;

use App\Http\Resources\Round as RoundResource;
use App\Models\Guess;
use App\Models\Room;
use App\Models\Round;
use App\Models\Track;
use App\Services\Spotify\Facades\Spotify;

use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Round|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Room $room)
    {
        $this->authorize('create', [Round::class, $room]);

        if (($track = Track::for($room)->next()) === null) {
            return response()->json(['message' => "No tracks for room"], 401);
        }

        $round = $room->rounds()->make();
        $round->track_id = $track->id;
        $round->save();

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
            ->whereBetween('created_at', [$round->created_at, $round->completes_at])
            ->correct()
            ->latest()
            ->get();

        $playerCount = $guesses->pluck('player_id')->count();

        // Decide how many points are awarded based on how many players participated.
        $points = 100 * $playerCount;

        // Compute a guess quality - faster means better.
        $guesses = $guesses->map(function (Guess $guess) use ($round) {
            $guess->quality = $guess->created_at->diffInSeconds($round->playback_at);

            return $guess;
        });

        // Compute the total quality.
        $quality = $guesses->reduce(fn (int $carry, Guess $guess) => $guess->quality + $carry, 0);

        // Score each guess according to its quality.
        foreach ($guesses as $guess) {
            $guess->player->increment('score', $guess->quality * ($points / $quality));
        }

        return new RoundResource($round);
    }
}
