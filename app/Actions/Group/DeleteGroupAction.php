<?php

namespace App\Actions\Group;

use App\Actions\Action;
use App\Models\Group;
use App\Repositories\GroupRepository;

class DeleteGroupAction extends Action
{
    public function __construct(protected GroupRepository $groupRepository)
    {
    }

    protected function handler(array $validatedPayload, array $payload): bool
    {
        return $this->groupRepository->delete($payload['group']->id);
    }
}
