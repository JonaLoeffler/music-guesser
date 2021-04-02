<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Round extends JsonResource
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
            'number' => $this->number,
            'spotify_track_uri' => $this->spotify_track_uri,
            'play_at' => $this->created_at->addSeconds(10),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
