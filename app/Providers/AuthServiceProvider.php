<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate para verificar si el usuario es supervisora
        Gate::define('supervisora', function ($user) {
            return $user->rol === 'supervisora';
        });

        // Gate para verificar si el usuario es enfermera
        Gate::define('enfermera', function ($user) {
            return $user->rol === 'enfermera';
        });
    }
}
