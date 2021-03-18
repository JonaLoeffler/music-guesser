<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Room extends JsonResource
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
            'id' => $this->id,
            'players' => Player::collection($this->whenLoaded('players')),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
