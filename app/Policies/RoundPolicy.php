<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\Room;
use App\Models\Round;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoundPolicy
{
    use HandlesAuthorization;

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
}
