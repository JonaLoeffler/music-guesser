<?php

namespace App\Services\Spotify;

use App\Services\Spotify\Exceptions\LoginFailed;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            return $this->http()
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
     * Get a HTTP instance.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function http(): PendingRequest
    {
        return Http::withBasicAuth($this->clientId, $this->clientSecret);
    }
}
