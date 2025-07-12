<?php

namespace App\Providers;

use App\Actions\Menu\GetMainNavigationGroupAction;
use App\Actions\Menu\GetMenuByGroupAction;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'sidebarMenus' => function (
                GetMainNavigationGroupAction $getMainNavigationGroupAction,
                GetMenuByGroupAction $getMenuByGroupAction) {

                return $getMenuByGroupAction->execute([
                    'id' => $getMainNavigationGroupAction->execute()->getKey(),
                ]);
            },
        ]);
    }
}
