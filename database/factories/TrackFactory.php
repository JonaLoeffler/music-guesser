<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Track::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id' => Room::factory(),
            'name' => $this->faker->words(3, true),
            'uri' => $this->faker->uuid,
        ];
    }
}
