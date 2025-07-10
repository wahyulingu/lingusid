<?php

namespace App\Actions\Group;

use App\Actions\RuledAction;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Support\Str;

class UpdateGroupAction extends \App\Actions\RuledAction implements \App\Contracts\Action\RuledActionContract
{
    public function __construct(protected GroupRepository $groupRepository)
    {
    }

    protected function handler(array $validatedPayload, array $payload): Group
    {
        $group = $payload['group'];

        $this->groupRepository->update($group->id, [
            'name' => $validatedPayload['name'],
            'slug' => Str::slug($validatedPayload['name']),
            'type' => $validatedPayload['type'],
            'description' => json_encode([
                'url' => $validatedPayload['url'] ?? null,
                'icon' => $validatedPayload['icon'] ?? null,
            ]),
            'parent_id' => $validatedPayload['parent_id'] ?? null,
        ]);

        return $group->fresh();
    }

    public function rules(array $payload): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:groups,id',
        ];
    }
}
