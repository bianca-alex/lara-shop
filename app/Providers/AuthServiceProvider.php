<?php

namespace App\Providers;

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
         'App\Models\UserAddress' => 'App\Policies\UserAddressPolicy',
         'App\Models\Order' => 'App\Policies\OrderPolicy',
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
        /*Gate::guessPolicyNamesUsing(function ($modelClass) {
            return "\\App\\Pplicies\\".class_basename($modelClass).'Policy';
        });*/
    }
}
