<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Actions\Group\CreateGroupAction;
use App\Models\Menu;
use App\Repositories\GroupRepository;

class GetMainNavigationGroupAction extends Action
{
    public function __construct(
        protected readonly GroupRepository $groupRepository,
        protected readonly CreateGroupAction $createGroupAction
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        $mainNavigationGroup = $this->groupRepository->index(
            filters: ['type' => Menu::class, 'slug' => 'system-main-navigation-menu']
        )->first();

        if (! $mainNavigationGroup) {
            $mainNavigationGroup = $this->createGroupAction->handle([
                'name' => 'System Main Navigation Menu',
                'description' => 'This group holds the main navigation menu items.',
            ]);
        }

        return $mainNavigationGroup;
    }
}
