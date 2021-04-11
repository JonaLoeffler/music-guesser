<?php

namespace Database\Factories;

use App\Models\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Round::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->randomNumber(1),
            'spotify_track_uri' => 'spotify:track:2LBjwUnpQ9dFKFaZ2QlTgL',
            'spotify_track_name' => 'Leev Marie',
        ];
    }
}
