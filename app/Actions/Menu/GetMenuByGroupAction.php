<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Models\Group;
use App\Repositories\MenuRepository;
use InvalidArgumentException;

class GetMenuByGroupAction extends Action
{
    public function __construct(
        protected readonly MenuRepository $menuRepository
    ) {}

    protected function handler($group, array $validatedPayload = []): mixed
    {

        if (! $group instanceof Group) {

            throw new InvalidArgumentException(sprintf('Unexpected group mustbe instaceof %s.', Group::class));
        }

        return $this->menuRepository->getByGroupId($group->getKey());
    }
}
