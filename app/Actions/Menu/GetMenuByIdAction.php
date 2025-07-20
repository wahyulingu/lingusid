<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Repositories\MenuRepository;

class GetMenuByIdAction extends Action
{
    public function __construct(private MenuRepository $menuRepository) {}

    public function handler($payload, array $validatedPayload = []): mixed
    {
        return $this->menuRepository->find($payload['id']);
    }
}
