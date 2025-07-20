<?php

namespace App\Actions\Group;

use App\Abstractions\Actions\Action;
use App\Repositories\GroupRepository;
use Illuminate\Support\Str;

class GetSystemGroupAction extends Action
{
    public function __construct(
        protected readonly GroupRepository $groupRepository,
        protected readonly CreateGroupAction $createGroupAction
    ) {}

    protected function handler($payload, array $validatedPayload = []): mixed
    {
        $slug = Str::start($payload, 'system-related-group-');

        $group = $this->groupRepository->index(filters: compact('slug'))->first();

        if (! $group) {
            $name = Str::of($slug)->replace('-', ' ')->title()->toString();

            $group = $this->createGroupAction->handle([
                ...compact('name'),
                'description' => sprintf('This group is for the %s functionalities.', $name),
            ]);
        }

        return $group;
    }
}
