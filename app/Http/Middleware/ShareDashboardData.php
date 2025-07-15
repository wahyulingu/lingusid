<?php

namespace App\Http\Middleware;

use App\Actions\Menu\GetMainNavigationGroupAction;
use App\Actions\Menu\GetMenuByGroupAction;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareDashboardData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
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

        return $next($request);
    }
}
