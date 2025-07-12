<?php

namespace App\Actions\Group;

use App\Contracts\Action\RuledActionContract;
use App\Models\Group;
use App\Repositories\GroupRepository;

class CreateGroupAction extends \App\Actions\RuledAction implements RuledActionContract
{
    public function __construct(protected GroupRepository $groupRepository) {}

    protected function handler(array $validatedPayload, array $payload): Group
    {
        return $this->groupRepository->store([
            'name' => $validatedPayload['name'],
            'type' => $validatedPayload['type'],
            'description' => $validatedPayload['description'],
            'parent_id' => $validatedPayload['parent_id'] ?? null,
        ]);
    }

    public function rules(array $payload): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:groups,id',
        ];
    }
}
