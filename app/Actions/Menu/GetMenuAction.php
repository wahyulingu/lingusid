<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class GetMenuAction extends BaseAction
{
    /**
     * @return Collection<int, Menu>
     */
    public function handler(array $validatedPayload, array $payload): mixed
    {
        return Menu::all();
    }
}
