<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

use Illuminate\Support\Facades\Gate;
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
        Inertia::share('flash', function () {
            return session('flash');
        });

        // Register General Permissions as Gates
        $this->registerPermissions();
    }

    /**
     * Register general permissions defined in PermissionSeeder.
     */
    protected function registerPermissions(): void
    {
        $permissions = [
            'dashboard.view',
            'warning.view',
            'post.view',
            'locution.view',
            'radio.view',
            'podcast.view',
            'marketing.view',
            'media.view',
            'administration.view',
            'log.view',
            'locution.start',
            'locution.finish',
            'listener.month.view',
            'listener.month.set',
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}
