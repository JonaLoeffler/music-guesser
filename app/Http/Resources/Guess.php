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
            'id' => $this->id,
            'track' => $this->track,
            'status' => $this->status,
            'player' => new Player($this->player),
            'round' => new Round($this->round),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
