<?php

namespace App\Providers;

use App\Policies\Users\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Spatie\Permission\Models\Permission::class => App\Policies\Users\PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::personalAccessTokensExpireIn(now()->addDays(1));

        Gate::before(function ($user, $ability) {
            dd(1);
            if ($user->hasRole('Super Admin')) return true;
        });
    }
}
