<?php

namespace App\Services\Menu;

use App\Models\Group;
use App\Repositories\GroupRepository;

class MenuService
{
    public function __construct(
        protected GroupRepository $groupRepository
    ) {}

    public function getMainNavigationGroup(): Group
    {
        $mainNavigationGroup = $this->groupRepository->index(
            filters: ['type' => 'menu_container', 'name' => 'Main Navigation']
        )->first();

        if (! $mainNavigationGroup) {
            $mainNavigationGroup = $this->groupRepository->store([
                'name' => 'Main Navigation',
                'slug' => 'main-navigation',
                'type' => 'menu_container',
                'description' => 'This group holds the main navigation menu items.',
            ]);
        }

        return $mainNavigationGroup;
    }
}
