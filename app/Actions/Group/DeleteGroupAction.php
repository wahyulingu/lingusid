<?php

namespace App\Actions\Group;

use App\Abstractions\Actions\Action;
use App\Repositories\GroupRepository;

class DeleteGroupAction extends Action
{
    public function __construct(protected GroupRepository $groupRepository) {}

    protected function handler($payload, array $validatedPayload = []): bool
    {
        return $this->groupRepository->delete($payload['group']->id);
    }
}
