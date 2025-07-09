<?php

namespace App\Actions\Menu;

use App\Actions\RulledAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;

class UpdateMenuAction extends RulledAction
{
    public function __construct(protected MenuRepository $menuRepository)
    {
    }

    public function handle(Menu $menu, array $data): Menu
    {
        $validatedData = $this->validate($data);

        $this->menuRepository->update($menu->id, [
            'name' => $validatedData['name'],
            'url' => $validatedData['url'] ?? null,
            'icon' => $validatedData['icon'] ?? null,
            'order' => $validatedData['order'] ?? 0,
            'parent_id' => $validatedData['parent_id'] ?? null,
            'group_id' => $validatedData['group_id'],
        ]);

        return $menu->fresh();
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'group_id' => 'required|exists:groups,id',
        ];
    }
}