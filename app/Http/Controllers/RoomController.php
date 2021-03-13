<?php

namespace App\Http\Controllers;

use App\Models\Room;
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
                $player  = $room->players()->create(),
                true,
            );
        }

        return response()
            ->view('room', ['room' => $room]);
    }
}
