<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Amenity;
use App\Policies\AmenityPolicy;
use App\Policies\UserInformationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        UserInformation::class => UserInformationPolicy::class,
        Hotel::class => HotelPolicy::class,
        TypeRoom::class => HotelPolicy::class,
        Amenity::class => AmenityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Passport::tokensExpireIn(now()->addDays(15));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addDays(30));
    }
}
