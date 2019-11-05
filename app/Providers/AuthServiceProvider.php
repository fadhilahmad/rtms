<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Add as GateContract
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // set the difference policies to different type of users
        
        //admin
        $gate->define('isAdmin', function($user){
            return $user->u_type == 1 || $user->u_type == 2 ;
        });

        //department
        $gate->define('isDepartment', function($user){
            return $user->u_type == 3 || $user->u_type == 4 || $user->u_type == 5;
        });

        //customer
        $gate->define('isCustomer', function($user){
            return $user->u_type == 7 || $user->u_type == 6;
        });

    }
}
