<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Track;
use Illuminate\Support\Collection;

class TrackSelector
{
    public function __construct(protected Room $room)
    {
        //
    }

    /**
     * Find the next track to play in the current room.
     *
     * @return \App\Models\Track|null
     */
    public function next(): ?Track
    {
        return $this->room->tracks()
            ->where('uri', 'not like', '%local%')
            ->inRandomOrder()
            ->whereNotIn('id', $this->played()->pluck('id'))
            ->first();
    }

    /**
     * Find played tracks of the current room.
     *
     * @return \Illuminate\Support\Collection<Track>
     */
    protected function played(): Collection
    {
        return $this->room->rounds()
            ->with('track')
            ->get()
            ->map->track;
    }
}
