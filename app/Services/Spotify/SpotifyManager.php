<?php

namespace App\Services\Spotify;

use App\Services\Spotify\Exceptions\LoginFailed;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SpotifyManager
{
    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected string $url
    ) {
        //
    }

    /**
     * Authenticate the given player with Spotify.
     *
     * @param  string  $code
     * @return \Illuminate\Support\Collection
     *
     * @throws \App\Services\Spotify\Exceptions\LoginFailed
     */
    public function authenticate(string $code): Collection
    {
        try {
            return $this->basic()
                ->asForm()
                ->post($this->url . config('services.spotify.paths.token'), [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => route('callback.spotify'),
                ])->throw()
                ->collect();
        } catch (RequestException $e) {
            Log::error("Spotify login failed with message: {$e->response->body()}");

            throw new LoginFailed("Login fehlgeschlagen. Bitte versuche es später erneut.", 0, $e);
        }
    }

    /**
     * Return the content of the specified playlist.
     *
     * @param  string  $uri
     * @param  string  $token
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function playlist(string $uri, string $token): Collection
    {
        $id = Str::of($uri)->afterLast(':');

        return $this->token($token)
            ->asForm()
            ->get("https://api.spotify.com/v1/playlists/{$id}")
            ->throw()
            ->collect();
    }

    /**
     * Get a HTTP instance.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function basic(): PendingRequest
    {
        return Http::withBasicAuth($this->clientId, $this->clientSecret);
    }

    /**
     * Get a HTTP instance.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function token(string $token): PendingRequest
    {
        return Http::withToken($token);
    }
}
