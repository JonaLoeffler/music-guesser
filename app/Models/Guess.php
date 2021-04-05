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

    public const WRONG = 'wrong';
    public const CLOSE = 'close';
    public const CORRECT = 'correct';

    public const STATUSES = [
        self::WRONG,
        self::CLOSE,
        self::CORRECT,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'player_id',
        'track',
        'status',
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
