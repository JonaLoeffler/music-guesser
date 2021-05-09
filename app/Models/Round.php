<?php

namespace App\Models;

use App\Events\RoundStarted;
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

        self::created(fn (self $round) => event(new RoundStarted($round)));
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function guesses()
    {
        return  $this->hasMany(Guess::class);
    }

    public function getPlaybackAtAttribute()
    {
        return $this->created_at->addSeconds(5);
    }

    public function getCompletesAtAttribute()
    {
        return $this->created_at->addSeconds(30);
    }
}
