<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\Collection;

class GetMenusAction extends Action
{
    public function __construct(private MenuRepository $menuRepository) {}

    /**
     * @return Collection<Menu>
     */
    public function handler($payload, array $validatedPayload = []): Collection
    {
        return $this->menuRepository->all();
    }
}
