<?php

namespace App\Models;

use App\Services\TrackSelector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'uri',
    ];

    public static function for(Room $room): TrackSelector
    {
        return new TrackSelector($room);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
