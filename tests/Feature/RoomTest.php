<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateRoomButtonExists()
    {
        $this->get('/')
            ->assertSee('Create new room')
            ->assertStatus(200);
    }

    public function testRoomCanBeCreated()
    {
        $response = $this->post('/rooms')
            ->assertStatus(302);

        $room = Room::first();

        $response->assertRedirect("/rooms/{$room->id}");
    }

    public function testRoomCanBeVisited()
    {
        $room = Room::factory()->create();

        $this->get("/rooms/{$room->id}")
            ->assertStatus(200);
    }

    public function testVisitingARoomLogsInPlayers()
    {
        $room = Room::factory()->create();

        $this->get("/rooms/{$room->id}")
            ->assertOk();

        $this->assertAuthenticated();

        $this->assertDatabaseCount('players', 1);
    }

    public function testRoomCanBeVisitedAsExistingPlayer()
    {
        $room = Room::factory()->create();
        $player = Player::factory()->for($room)->create();

        $this->actingAs($player)
            ->get("/rooms/{$room->id}")
            ->assertOk();

        $this->assertAuthenticated();

        $this->assertDatabaseCount('players', 1);
    }
}
