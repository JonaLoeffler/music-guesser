<?php

namespace App\Policies;

use App\Models\Player;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Player  $player
     * @param  \App\Models\Player  $player
     * @return mixed
     */
    public function update(Player $user, Player $player)
    {
        // Players can only edit themselves.
        return $user->id === $player->id;
    }
}
