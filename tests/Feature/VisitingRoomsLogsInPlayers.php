<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VisitingRoomsLogsInPlayers extends TestCase
{
    use RefreshDatabase;

    public function testVisitingARoomLogsInPlayers()
    {
        $room = Room::factory()->create();

        $this->get("/rooms/{$room->id}")
            ->assertOk();

        $this->assertDatabaseCount('players', 1);
    }

    public function testRoomCanBeVisitedAsExistingPlayer()
    {
        $room = Room::factory()->create();
        $player = Player::factory()->create();

        $this->actingAs($player)
            ->get("/rooms/{$room->id}")
            ->assertOk();

        $this->assertDatabaseCount('players', 1);
    }
}
