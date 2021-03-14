<?php

namespace Tests\Feature\Api;

use App\Models\Player;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testPlayerCanUpdateTheirInformation()
    {
        $player = Player::factory()->for(Room::factory())->create();
        $name = $this->faker->userName;

        $this->actingAs($player)
            ->patch("/players/{$player->id}", ['name' => $name])
            ->assertOk()
            ->assertJsonPath('data.id', $player->id)
            ->assertJsonPath('data.name', $name);
    }

    public function testPlayersCannotEditOthers()
    {
        $room = Room::factory()->create();
        $player1 = Player::factory()->for($room)->create();
        $player2 = Player::factory()->for($room)->create();

        $this->actingAs($player1)
            ->patch("/players/{$player2->id}")
            ->assertForbidden();
    }
}
