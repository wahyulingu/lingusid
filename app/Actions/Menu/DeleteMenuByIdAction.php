<?php

namespace App\Actions\Menu;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\MenuRepository;
use Illuminate\Validation\Rule;

class DeleteMenuByIdAction extends Action implements RuledActionContract
{
    public function rules($payload = []): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('menus', 'id')],
        ];
    }

    public function __construct(protected MenuRepository $menuRepository) {}

    protected function handler($payload, array $validatedPayload = []): bool
    {
        return $this->menuRepository->delete($validatedPayload['id']);
    }
}
