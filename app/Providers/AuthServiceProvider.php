<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {

            if (in_array($ability, ['backup', 'superadmin'])) {
                $administrator_list = env('ADMINISTRATOR_USERNAMES');
                if (in_array($user->username, explode(',', $administrator_list))) {
                    return true;
                }
            } else {
                if ($user->hasRole('Super Admin#' . $user->business_id)) {
                    return true;
                }
            }
        });
    }
}
