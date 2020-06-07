<?php
namespace App\Providers;

use App\Auth\EloquentAdminUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('admin', function($app, array $config) {
            return new EloquentAdminUserProvider($app['hash'], $config['model']);
        });
    }
}
