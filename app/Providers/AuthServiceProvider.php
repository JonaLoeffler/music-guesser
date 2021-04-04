<?php

namespace App\Providers;

use App\Models\Guess;
use App\Models\Player;
use App\Models\Round;
use App\Policies\GuessPolicy;
use App\Policies\PlayerPolicy;
use App\Policies\RoundPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Round::class => RoundPolicy::class,
        Guess::class => GuessPolicy::class,
        Player::class => PlayerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
