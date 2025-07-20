<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Menu;
use App\Repositories\MenuRepository;

class CreateMenuAction extends Action implements RuledActionContract
{
    public function __construct(protected MenuRepository $menuRepository) {}

    protected function handler($payload, array $validatedPayload = []): Menu
    {
        $menu = $this->menuRepository->store([
            'name' => $validatedPayload['name'],
            'url' => $validatedPayload['url'] ?? null,
            'icon' => $validatedPayload['icon'] ?? null,
            'order' => $validatedPayload['order'] ?? 0,
            'parent_id' => $validatedPayload['parent_id'] ?? null,

        ]);

        if (isset($validatedPayload['group_id'])) {
            $menu->groups()->sync($validatedPayload['group_id']);
        }

        return $menu;
    }

    public function rules(array $payload): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'group_id' => 'nullable|exists:groups,id',
        ];
    }
}
