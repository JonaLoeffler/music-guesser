<?php

namespace Database\Factories;

use App\Models\Round;
use App\Models\Track;
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
            'track_id' => Track::factory(),
        ];
    }
}
