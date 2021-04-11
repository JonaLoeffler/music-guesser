<?php

namespace Tests\Feature\Api;

use App\Models\Player;
use App\Models\Room;
use App\Models\Round;
use App\Services\Spotify\Facades\Spotify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoundTest extends TestCase
{
    use RefreshDatabase;

    public function testNonCreatorCannotStartRound()
    {
        $room = Room::factory()->create();
        $player = Player::factory()->for($room)->create();

        $this->actingAs($player)->post("/rooms/{$room->id}/rounds")
            ->assertStatus(403);
    }

    public function testCreatorCanStartRound()
    {
        $room = Room::factory()->create();
        $player = Player::factory()->for($room)->create(['is_creator' => true, 'spotify_access_token' => 'token']);

        Spotify::shouldReceive('playlist')
            ->andReturn(collect(['tracks' => ['items' => [['track' => ['name' => 'Test', 'uri' => 'uri']]]]]));

        $this->actingAs($player)->post("/rooms/{$room->id}/rounds")
            ->assertStatus(201)
            ->assertJson(['data' => [
                'spotify_track_name' => 'Test',
                'spotify_track_uri' => 'uri',
            ]]);
    }

    public function testCreatorCanFinishRound()
    {
        $room = Room::factory()->create();
        $round = Round::factory()->for($room)->create(['created_at' => now()->subMinutes(4)]);
        $player = Player::factory()->for($room)->create(['is_creator' => true]);

        $this->actingAs($player)->put("/rooms/{$room->id}/rounds/{$round->id}")
            ->assertStatus(200);

        // No guesses so player score should still be zero
        $this->assertDatabaseHas('players', ['id' => $player->id, 'score' => 0]);
    }

    public function testRoundMustBeCompleteBeforeFinishing()
    {
        $room = Room::factory()->create();
        $round = Round::factory()->for($room)->create();
        $player = Player::factory()->for($room)->create(['is_creator' => true]);

        $this->actingAs($player)->put("/rooms/{$room->id}/rounds/{$round->id}")
            ->assertStatus(403);
    }
}
