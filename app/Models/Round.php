<?php

namespace App\Models;

use App\Events\PlayTrack;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Round
 *
 * @property Room $room
 */
class Round extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'spotify_track_uri',
        'spotify_track_name',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::creating(function (self $round) {
            // Make sure to count archived and soft deleted entries.
            $round->number = self::withoutGlobalScopes()
                ->where('room_id', $round->room_id)
                ->count() + 1;
        });

        self::created(fn (self $round) => event(new PlayTrack($round)));
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guesses()
    {
        return  $this->hasMany(Guess::class);
    }
}
