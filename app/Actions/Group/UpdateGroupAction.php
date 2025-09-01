<?php

namespace App\Actions\Group;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\GroupRepository;

class UpdateGroupAction extends Action implements RuledActionContract
{
    public function __construct(protected GroupRepository $groupRepository) {}

    protected function handler($payload = null, array $validatedPayload = []): mixed
    {
        $groupId = $payload['id'];
        unset($payload['id']);

        return $this->groupRepository->update($groupId, $validatedPayload);
    }

    public function rules(array $payload): array
    {
        return [
            'description' => 'nullable|string|max:1000',
            'name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'id' => 'required|exists:groups,id',
        ];
    }
}
