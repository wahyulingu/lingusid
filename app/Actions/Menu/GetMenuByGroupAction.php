<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\MenuRepository;
use Illuminate\Support\Collection;

class GetMenuByGroupAction extends BaseAction implements RuledActionContract
{
    public function __construct(
        protected readonly MenuRepository $menuRepository
    ) {}

    protected function handler(array $validatedPayload, array $payload): Collection
    {
        return $this->menuRepository->getByGroupId($payload['id']);
    }

    public function rules(array $payload): array
    {
        // Define your validation rules here
        return [
            'id' => ['required', 'exists:groups'],
        ];
    }
}
