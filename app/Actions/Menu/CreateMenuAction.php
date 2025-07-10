<?php

namespace App\Actions\Menu;

use App\Models\Menu;
use App\Repositories\MenuRepository;

class CreateMenuAction extends \App\Actions\RuledAction implements \App\Contracts\Action\RuledActionContract
{
    public function __construct(protected MenuRepository $menuRepository) {}

    protected function handler(array $validatedPayload, array $payload): Menu
    {
        return $this->menuRepository->store([
            'name' => $validatedPayload['name'],
            'url' => $validatedPayload['url'] ?? null,
            'icon' => $validatedPayload['icon'] ?? null,
            'order' => $validatedPayload['order'] ?? 0,
            'parent_id' => $validatedPayload['parent_id'] ?? null,

        ]);
    }

    public function rules(array $payload): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',

        ];
    }
}
