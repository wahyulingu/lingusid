<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Repositories\MenuRepository;

class GetMenuByIdAction extends BaseAction
{
    public function __construct(private MenuRepository $menuRepository)
    {
    }

    public function handler(string $id)
    {
        return $this->menuRepository->find($id);
    }
}
