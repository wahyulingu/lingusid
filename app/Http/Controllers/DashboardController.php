<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Repositories\GroupRepository;
use App\Repositories\MenuItemRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected Group $mainNavigationGroup;

    public function __construct(
        protected GroupRepository $groupRepository,
        protected MenuItemRepository $menuItemRepository
    ) {
        $this->mainNavigationGroup = $this->groupRepository->index(
            filters: ['type' => 'menu_container', 'name' => 'Main Navigation']
        )->first();

        if (! $this->mainNavigationGroup) {
            // Handle case where main navigation group doesn't exist
            // For now, we'll just create it, or throw an error
            $this->mainNavigationGroup = $this->groupRepository->store([
                'name' => 'Main Navigation',
                'slug' => 'main-navigation',
                'type' => 'menu_container',
                'description' => 'This group holds the main navigation menu items.',
            ]);
        }
    }

    public function index()
    {
        $sidebarMenus = $this->menuItemRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null],
            relations: ['children'],
            orderBy: 'order',
            orderDirection: 'asc'
        );

        return Inertia::render('Dashboard', [
            'sidebarMenus' => $sidebarMenus,
        ]);
    }
}
