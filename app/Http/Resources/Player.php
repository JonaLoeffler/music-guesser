<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Player extends JsonResource
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
            'name' => $this->name,
            'score' => $this->score,
            'is_creator' => $this->is_creator,
            'spotify_access_token' => $this->when($this->id === $request->user()->id, $this->spotify_access_token),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
