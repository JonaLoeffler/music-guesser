<?php

namespace App\Http\Controllers;

use App\Http\Resources\Player;
use App\Http\Resources\Room as ResourcesRoom;
use App\Models\Room;
use Faker\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        return redirect()->route('rooms.show', ['room' => Room::create()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Room $room)
    {
        $player = $request->user();

        // If no player is authenticated or the room does not contain the player,
        // we will create a new player and log them in.
        if ($player === null || !$room->players->contains($player)) {
            Auth::login(
                $player = $room->players()->create([
                    // Generate a random username.
                    'name' => app(Generator::class)->userName,
                    // The first player to enter a room is the creator.
                    'is_creator' => $room->players->isEmpty(),
                ]),
                true,
            );
        }

        return response()
            ->view(
                'room',
                [
                    'room' => (new ResourcesRoom($room))->toJson(),
                    'player' => (new Player($player))->toJson(),
                ],
            );
    }
}
