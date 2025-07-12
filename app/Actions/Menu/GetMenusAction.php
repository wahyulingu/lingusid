<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\Collection;

class GetMenusAction extends BaseAction
{
    public function __construct(private MenuRepository $menuRepository) {}

    /**
     * @return Collection<Menu>
     */
    public function handler(array $validatedPayload, array $payload): Collection
    {
        return $this->menuRepository->all();
    }
}
