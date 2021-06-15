<?php

namespace App\Http\Controllers;

use App\Http\Resources\Track as TrackResource;
use App\Models\Room;
use App\Models\Track;
use App\Services\Spotify\Facades\Spotify;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(Request $request, Room $room)
    {
        $this->authorize('create', [Track::class, $room]);

        $request->validate([
            'playlist_uri' => 'required|string',
        ]);

        $response = Spotify::playlist(
            $request->playlist_uri,
            $request->user()->spotify_access_token
        );

        $tracks = collect($response['tracks']['items'])->map->track->map(fn (array $track) => new Track($track));

        $tracks = $room->tracks()->saveMany($tracks);

        return TrackResource::collection($tracks);
    }
}
