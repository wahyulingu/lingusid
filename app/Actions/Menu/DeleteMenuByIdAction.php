<?php

namespace App\Actions\Menu;

use App\Contracts\Action\RuledActionContract;
use App\Repositories\MenuRepository;
use Illuminate\Validation\Rule;

class DeleteMenuByIdAction extends \App\Actions\BaseAction implements RuledActionContract
{
    public function rules($payload = []): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('menus', 'id')],
        ];
    }

    public function __construct(protected MenuRepository $menuRepository) {}

    protected function handler(array $validatedPayload, array $payload): bool
    {
        return $this->menuRepository->delete($validatedPayload['id']);
    }
}
