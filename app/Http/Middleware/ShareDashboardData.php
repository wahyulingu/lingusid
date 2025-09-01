<?php

namespace App\Http\Middleware;

use App\Actions\Web\Dashboard\Sidebar\GetAllSidebarMenuAction;
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

        $this->shareMenu();

        return $next($request);
    }

    protected function shareMenu(): void
    {
        Inertia::share([
            'sidebarMenus' => function (GetAllSidebarMenuAction $getAllSidebarMenu) {

                return $getAllSidebarMenu->handle();
            },
        ]);

    }
}
