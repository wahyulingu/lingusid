<?php

namespace App\Actions\Group;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Group;
use App\Repositories\GroupRepository;

class CreateGroupAction extends Action implements RuledActionContract
{
    public function __construct(protected GroupRepository $groupRepository) {}

    protected function handler($payload, array $validatedPayload = []): Group
    {
        return $this->groupRepository->store([
            'name' => $validatedPayload['name'],
            'description' => $validatedPayload['description'],
        ]);
    }

    public function rules(array $payload): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
        ];
    }
}
