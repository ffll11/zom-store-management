<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Brand::class => ProductPolicy::class,

    ];

    public function boot(): void
    {

        Gate::define('manage-products', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        Gate::define('access-admin', function (User $user) {
            return $user->role_id === User::ROLE_ADMIN;
        });

    }
}
