<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

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
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        \Illuminate\Support\Facades\Gate::define('manage-users', function (User $user) {
            return $user->isSuperAdmin();
        });

        \Illuminate\Support\Facades\Gate::define('manage-settings', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });

        \Illuminate\Support\Facades\Gate::define('manage-pages', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });

        \Illuminate\Support\Facades\Gate::define('manage-seo', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });
    }
}
