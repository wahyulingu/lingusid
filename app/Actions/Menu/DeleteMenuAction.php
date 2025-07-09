<?php

namespace App\Actions\Menu;

use App\Actions\Action;
use App\Models\Menu;
use App\Repositories\MenuRepository;

class DeleteMenuAction extends Action
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