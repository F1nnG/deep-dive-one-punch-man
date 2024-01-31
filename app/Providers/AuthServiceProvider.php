<?php

namespace App\Providers;

use App\Models\Availability;
use App\Models\User;
use App\Policies\AvailabilityPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Availability::class => AvailabilityPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
