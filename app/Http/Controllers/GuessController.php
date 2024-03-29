<?php

namespace App\Http\Controllers;

use App\Http\Resources\Guess as GuessResource;
use App\Models\Guess;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuessController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Round  $round
     * @return \App\Http\Resources\Guess
     */
    public function store(Request $request, Round $round)
    {
        $this->authorize('create', [Guess::class, $round]);

        $request->validate([
            'track' => 'required|string|min:3|max:255',
        ]);

        $guess = $round->guesses()->create([
            'player_id' => $request->user()->id,
            'track' => $request->track,
            'status' => strtolower($request->track) == strtolower($round->track->name)
                ? Guess::CORRECT
                : Guess::WRONG,
        ]);

        return new GuessResource($guess);
    }
}
