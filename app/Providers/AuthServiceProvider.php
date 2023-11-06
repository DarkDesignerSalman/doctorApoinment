<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
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
        $this->registerPolicies();

    Gate::define('access-resource', function ($user, $resource) {
        // Your authorization logic here

        if (!$user->canAccessResource($resource)) {
            abort(403, 'You are not authorized to access this resource.');
        }

        return true;
    });
    }
}
