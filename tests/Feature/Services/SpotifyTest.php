<?php

namespace Tests\Feature\Services;

use App\Services\Spotify\Facades\Spotify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SpotifyTest extends TestCase
{
    public function testSpotifyAuthenticationWorks()
    {
        Http::fake([
            'spotify.com/*'  => Http::response(['access_token' => 'token']),
        ]);

        $code = "testcode";

        $result = Spotify::authenticate($code);

        Http::assertSent(
            fn (Request $request) => $request->isForm()
                && $request['grant_type'] === 'authorization_code'
                && $request['code'] === $code
                && $request['redirect_uri'] === route('callback.spotify')
        );

        $this->assertEquals('token', $result['access_token']);
    }

    public function testSpotifyPlaylistWorks()
    {
        Http::fake([
            'spotify.com/*'  => Http::response(['tracks' => []]),
        ]);

        $uri = "uri";
        $token = "token";

        $result = Spotify::playlist($uri, $token);

        Http::assertSent(
            fn (Request $request) => $request->isForm()
                && $request->hasHeader('Authorization', "Bearer {$token}"),
        );
    }
}
