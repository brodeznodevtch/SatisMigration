<?php

namespace App\Providers;

use DB;
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
                if ($user->hasRole('Implementaciones#'.$user->business_id)) {
                    return true;
                } else {
                    if ($user->hasRole('Super Admin#'.$user->business_id)) {
                        // $permission = DB::table('permissions as permission')
                        //     ->leftJoin('modules as module', 'module.id', '=', 'permission.module_id')
                        //     ->select('permission.*', 'module.name as module')
                        //     ->where('permission.deleted_at', NULL)
                        //     ->where('permission.name', $ability)
                        //     ->where('module.deleted_at', NULL)
                        //     ->where('module.status', 1)
                        //     ->get();
                        // if(count($permission) > 0){
                        return true;
                        //}
                    }
                }
            }
        });
    }
}
