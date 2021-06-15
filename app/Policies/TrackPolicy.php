<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\Room;
use App\Models\Track;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Player  $player
     * @return mixed
     */
    public function viewAny(Player $player)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Track  $track
     * @return mixed
     */
    public function view(Player $player, Track $track)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Room  $room
     * @return mixed
     */
    public function create(Player $player, Room $room)
    {
        return $player->is($room->creator);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Track  $track
     * @return mixed
     */
    public function update(Player $player, Track $track)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Track  $track
     * @return mixed
     */
    public function delete(Player $player, Track $track)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Track  $track
     * @return mixed
     */
    public function restore(Player $player, Track $track)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Track  $track
     * @return mixed
     */
    public function forceDelete(Player $player, Track $track)
    {
        //
    }
}
