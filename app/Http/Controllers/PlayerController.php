<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Player as PlayerResource;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \App\Http\Resources\Player
     */
    public function update(Request $request, Player $player)
    {
        $this->authorize('update', $player);

        $request->validate([
            'name' => 'required|string|min:2|max:128',
        ]);

        $player->update([
            'name' => $request->name,
        ]);

        return new PlayerResource($player);
    }
}
