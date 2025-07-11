<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Repositories\MenuRepository;

class GetMenuByIdAction extends BaseAction
{
    public function __construct(private MenuRepository $menuRepository) {}

    public function handler(array $validatedPayload, array $payload): mixed
    {
        return $this->menuRepository->find($payload['id']);
    }
}
