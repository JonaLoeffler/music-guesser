<?php

namespace App\Services\Spotify\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection authenticate(string $code)
 *
 * @see \App\Services\Spotify\SpotifyManager
 */
class Spotify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'spotify';
    }
}
