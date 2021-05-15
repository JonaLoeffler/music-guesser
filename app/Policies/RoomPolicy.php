<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\Room;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Room  $room
     * @return mixed
     */
    public function view(Player $player, Room $room)
    {
        return $room->players->contains($player);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Player  $player
     * @return mixed
     */
    public function create(Player $player)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Room  $room
     * @return mixed
     */
    public function update(Player $player, Room $room)
    {
        return $player->is($room->creator);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Room  $room
     * @return mixed
     */
    public function delete(Player $player, Room $room)
    {
        return false;
    }
}
