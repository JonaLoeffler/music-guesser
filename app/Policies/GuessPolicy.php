<?php

namespace App\Policies;

use App\Models\Guess;
use App\Models\Player;
use App\Models\Round;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Round  $round
     * @return mixed
     */
    public function create(Player $player, Round $round)
    {
        // The current player must actually be in the room he wishes to create a guess for.
        return $round->room->players->contains($player)
            // The current round must be the latest in the player's room.
            && $round->is($player->room->rounds()->latest()->first());
    }
}
