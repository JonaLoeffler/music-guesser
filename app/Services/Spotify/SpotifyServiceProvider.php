<?php

namespace App\Services\Spotify;

use Illuminate\Support\ServiceProvider;

class SpotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('spotify', function () {
            return new SpotifyManager(
                config('services.spotify.client.id'),
                config('services.spotify.client.secret'),
                config('services.spotify.url'),
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
