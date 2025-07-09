<?php

namespace App\Actions\MenuItem;

use App\Actions\Action;
use App\Models\MenuItem;
use App\Repositories\MenuItemRepository;

class DeleteMenuItemAction extends Action
{
    public function __construct(protected MenuItemRepository $menuItemRepository)
    {
    }

    public function handle(MenuItem $menuItem): bool
    {
        return $this->menuItemRepository->delete($menuItem->id);
    }
}
