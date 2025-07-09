<?php

namespace App\Actions\MenuItem;

use App\Actions\RulledAction;
use App\Models\MenuItem;
use App\Repositories\MenuItemRepository;

class UpdateMenuItemAction extends RulledAction
{
    public function __construct(protected MenuItemRepository $menuItemRepository)
    {
    }

    public function handle(MenuItem $menuItem, array $data): MenuItem
    {
        $validatedData = $this->validate($data);

        $this->menuItemRepository->update($menuItem->id, [
            'name' => $validatedData['name'],
            'url' => $validatedData['url'] ?? null,
            'icon' => $validatedData['icon'] ?? null,
            'order' => $validatedData['order'] ?? 0,
            'parent_id' => $validatedData['parent_id'] ?? null,
            'group_id' => $validatedData['group_id'],
        ]);

        return $menuItem->fresh();
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menu_items,id',
            'group_id' => 'required|exists:groups,id',
        ];
    }
}
