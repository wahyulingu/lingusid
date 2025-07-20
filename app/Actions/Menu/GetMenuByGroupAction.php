<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Repositories\MenuRepository;
use Illuminate\Support\Collection;

class GetMenuByGroupAction extends Action
{
    public function __construct(
        protected readonly MenuRepository $menuRepository
    ) {}

    protected function handler($payload, array $validatedPayload = []): Collection
    {
        return $this->menuRepository->getByGroupId($payload);
    }
}
