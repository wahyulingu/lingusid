<?php

namespace App\Actions\Group;

use App\Models\Group;
use App\Repositories\GroupRepository;

class UpdateGroupAction extends \App\Actions\RuledAction implements \App\Contracts\Action\RuledActionContract
{
    public function __construct(protected GroupRepository $groupRepository) {}

    protected function handler(array $validatedPayload, array $payload): Group
    {
        $groupId = $validatedPayload['id'];
        unset($validatedPayload['id']);

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
            'parent_id' => 'nullable|exists:groups,id',
            'id' => 'required|exists:groups,id',
        ];
    }
}
