<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //admin can do whatever he wants
        $gate->before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        $gate->define('manage-post', function ($user, $post) {
            return $user->owns($post);
        });
        $gate->define('manage-category', function ($user, $category) {
            //only admins can
            return false;
        });
    }
}
