<?php

namespace App\Http\Controllers;

use App\Actions\Menu\GetMainNavigationGroupAction;
use App\Repositories\MenuRepository;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        protected MenuRepository $menuRepository,
        protected GetMainNavigationGroupAction $getMainNavigationGroupAction
    ) {
    }

    public function index()
    {
        $mainNavigationGroup = $this->getMainNavigationGroupAction->handle();

        $sidebarMenus = $this->menuRepository->index(
            filters: ['group_id' => $mainNavigationGroup->id, 'parent_id' => null],
            relations: ['children'],
            orderBy: 'order',
            orderDirection: 'asc'
        );

        return Inertia::render('Dashboard', [
            'sidebarMenus' => $sidebarMenus,
        ]);
    }
}
