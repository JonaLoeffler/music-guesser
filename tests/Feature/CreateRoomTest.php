<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateRoomTest extends TestCase
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
}
