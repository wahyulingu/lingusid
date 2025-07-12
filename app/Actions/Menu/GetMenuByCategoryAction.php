<?php

namespace App\Actions\Menu;

use App\Actions\BaseAction;
use App\Models\Group;
use Illuminate\Support\Collection;

class GetMenuByCategoryAction extends BaseAction
{
    protected function handler(array $validatedPayload, array $payload): Collection
    {
        return Group::with(['menus' => function ($query) {
            $query->whereNull('parent_id')->with('children')->orderBy('order');
        }])->get();
    }
}
