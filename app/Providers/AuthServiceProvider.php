<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('category-list','App\Policies\CategoryPolicy@view');
        Gate::define('category-create','App\Policies\CategoryPolicy@create');
        Gate::define('category-edit','App\Policies\CategoryPolicy@update');
        Gate::define('category-delete','App\Policies\CategoryPolicy@delete');
//        Gate::define('category-list',function ($user)
//        {
//            return $user->checkPermissionAccess(config('permissions.access.category-list'));
//        });
//        Gate::define('category-create',function ($user)
//        {
//            return $user->checkPermissionAccess('category_create');
//        });
//        Gate::define('category-edit',function ($user)
//        {
//            return $user->checkPermissionAccess(config('category_edit'));
//        });
//        Gate::define('menu-list',function ($user)
//        {
//            return $user->checkPermissionAccess(config('permissions.access.list-menu'));
//        });
    }
}
