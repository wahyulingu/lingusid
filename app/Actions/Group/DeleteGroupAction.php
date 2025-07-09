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

    public function handle(Group $group): bool
    {
        return $this->groupRepository->delete($group->id);
    }
}
