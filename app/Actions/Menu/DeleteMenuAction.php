<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;

class DeleteMenuAction extends \App\Actions\BaseAction
{
    public function __construct(protected MenuRepository $menuRepository)
    {
    }

    protected function handler(array $validatedPayload, array $payload): bool
    {
        $menu = $payload['menu'];
        return $this->menuRepository->delete($menu->id);
    }
}