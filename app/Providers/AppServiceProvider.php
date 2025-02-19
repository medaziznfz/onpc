<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        // hedha ken e super adin aandou el haq yodkhel
        Gate::define('super-admin', function ($user) {
            return $user->role === 2; // Ensure your User model has a 'role' attribute
        });

        // hedha e service o super admin e zouz
        Gate::define('service', function ($user) {
            return in_array($user->role, [1, 2]);
        });
    }
}
