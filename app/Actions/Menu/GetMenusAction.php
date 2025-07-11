<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Repositories\MenuRepository;

class GetMenusAction extends BaseAction
{
    public function __construct(private MenuRepository $menuRepository)
    {
    }

    public function handler()
    {
        return $this->menuRepository->all();
    }
}
