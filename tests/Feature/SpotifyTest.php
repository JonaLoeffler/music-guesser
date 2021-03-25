<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Room;
use App\Services\Spotify\Exceptions\LoginFailed;
use App\Services\Spotify\Facades\Spotify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpotifyTest extends TestCase
{
    use RefreshDatabase;

    public function testSpotifyCallbackWorks()
    {
        $player = Player::factory()->for(Room::factory())->create();

        Spotify::shouldReceive('authenticate')
            ->once()
            ->with('code')
            ->andReturn(collect([
                'access_token' => 'token',
                'token_type' => 'type',
                'expires_in' => 1000,
                'refresh_token' => 'refresh',
                'scope' => 'scope',
            ]));

        $response = $this->actingAs($player)
            ->call(
                'GET',
                '/callback/spotify',
                ['code' => 'code', 'state' => route('rooms.show', ['room' => $player->room])]
            );

        $response->assertStatus(302);

        $response->assertRedirect("/rooms/{$player->room->id}");

        $response->assertSessionMissing('error');

        $this->assertDatabaseHas('players', ['id' => $player->id, 'spotify_access_token' => 'token']);
    }

    public function testSpotifyCallbackFlashesErrorOnFail()
    {
        $player = Player::factory()->for(Room::factory())->create();

        Spotify::shouldReceive('authenticate')
            ->once()
            ->with('code')
            ->andThrow(new LoginFailed);

        $response = $this->actingAs($player)
            ->call(
                'GET',
                '/callback/spotify',
                ['code' => 'code', 'state' => route('rooms.show', ['room' => $player->room])]
            );

        $response->assertStatus(302);

        $response->assertRedirect("/rooms/{$player->room->id}");

        $response->assertSessionHas('error');
    }
}
