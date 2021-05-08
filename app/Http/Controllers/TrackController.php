<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Room $room)
    {
        $this->authorize('store', [Track::class, $room]);

        $request->validate([
            'playlist_uris' => 'required|array',
            'playlist_uris.*' => 'string',
        ]);

        
    }
}
