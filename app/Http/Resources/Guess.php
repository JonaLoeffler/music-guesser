<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Guess extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'track' => $this->track,
            'player' => new Player($this->player),
            'round' => new Round($this->round),
        ];
    }
}
