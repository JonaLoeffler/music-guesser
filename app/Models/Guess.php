<?php

namespace App\Models;

use App\Events\GuessReceived;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Guess
 *
 * @property \App\Models\Round $round
 */
class Guess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'player_id',
        'track',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        self::created(fn (self $guess) => event(new GuessReceived($guess)));
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
