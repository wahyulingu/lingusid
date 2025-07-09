<?php

namespace App\Actions\Group;

use App\Actions\RulledAction;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Support\Str;

class CreateGroupAction extends RulledAction
{
    public function __construct(protected GroupRepository $groupRepository)
    {
    }

    public function handle(array $data): Group
    {
        $validatedData = $this->validate($data);

        return $this->groupRepository->store([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'type' => $validatedData['type'],
            'description' => json_encode([
                'url' => $validatedData['url'] ?? null,
                'icon' => $validatedData['icon'] ?? null,
            ]),
            'parent_id' => $validatedData['parent_id'] ?? null,
        ]);
    }

    protected function rules(): array
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
