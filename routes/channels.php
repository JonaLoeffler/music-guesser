<?php

use App\Http\Resources\Player as PlayerResource;
use App\Models\Player;
use App\Models\Room;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('room.{room}', function (Player $player, Room $room) {
    if ($room->players->contains($player)) {
        return (new PlayerResource($player))->resolve();
    }
});
