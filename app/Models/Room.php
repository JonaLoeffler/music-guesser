<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Room
 *
 * @property \Illuminate\Database\Eloquent\Collection $players
 */
class Room extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->hasOne(Player::class)->where('is_creator', true);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }
}
