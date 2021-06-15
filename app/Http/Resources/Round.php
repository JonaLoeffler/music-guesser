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
            'track' => new Track($this->track),
            'playback_at' => $this->playback_at,
            'completes_at' => $this->completes_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,

        ];
    }
}
