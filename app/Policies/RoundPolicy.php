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

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Round  $round
     * @param  \App\Models\Room  $room
     * @return mixed
     */
    public function update(Player $player, Round $round, Room $room)
    {
        // Make sure the round has ended
        return $round->completes_at->lte(now())
            // Only the room creator finishes the round
            && $player->is($room->creator);
    }
}
