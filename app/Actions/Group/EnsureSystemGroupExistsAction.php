<?php

namespace App\Actions\Group;

use App\Abstractions\Actions\Action;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Support\Str;
use InvalidArgumentException;

class EnsureSystemGroupExistsAction extends Action
{
    public const SYSTEM_GROUP_PREFIX = 'system related group ';

    public function __construct(
        protected readonly GroupRepository $groupRepository,
        protected readonly CreateGroupAction $createGroupAction
    ) {}

    /**
     * @param  string  $groupKey  Slug atau identifier untuk grup sistem.
     * @param  array  $validatedPayload  Payload terverifikasi (jika validasi diaktifkan).
     */
    protected function handler($groupKey, array $validatedPayload = []): Group
    {

        if (! is_string($groupKey)) {

            throw new InvalidArgumentException('Expected string groupKey for group slug.');
        }

        $slug = Str::of($groupKey)->start(self::SYSTEM_GROUP_PREFIX)->slug()->toString();
        $group = $this->groupRepository->index(filters: compact('slug'))->first();

        if (! $group) {

            $name = Str::of($slug)->replace('-', ' ')->title()->toString();
            $description = sprintf('This group is for the %s functionalities.', Str::lower($name));

            return $this->createGroupAction->handle(compact('name', 'description'));
        }

        return $group;
    }
}
