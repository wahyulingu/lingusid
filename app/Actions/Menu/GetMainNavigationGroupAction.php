<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Services\Menu\MenuService;

class GetMainNavigationGroupAction extends BaseAction
{
    public function __construct(
        protected MenuService $menuService
    ) {}

    protected function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->menuService->getMainNavigationGroup();
    }
}
