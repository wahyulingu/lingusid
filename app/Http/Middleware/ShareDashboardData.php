<?php

namespace App\Http\Middleware;

use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Actions\Menu\GetMenuByGroupAction;
use App\Enums\System\GroupEnum;
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
                EnsureSystemGroupExistsAction $ensureSystemGroupExists,
                GetMenuByGroupAction $getMenuByGroup) {

                $sidebarMenuGroup = $ensureSystemGroupExists
                    ->execute(GroupEnum::DASHBOARD_SIDEBAR_MENU->value);

                return $getMenuByGroup->execute($sidebarMenuGroup);
            },
        ]);

        return $next($request);
    }
}
