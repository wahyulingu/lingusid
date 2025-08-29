<?php

namespace App\Repositories;

use App\Abstractions\Traits\Repository\HasModel;
use App\Contracts\Repository\ModelRepositoryContract;
use App\Contracts\Repository\RepositoryContract;
use App\Models\Menu;

class MenuRepository implements ModelRepositoryContract, RepositoryContract
{
    use HasModel;

    /**
     * Get menus that have a group with the given group ID.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    /**
     * Get menus that have a group with the given group ID.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Menu>
     */
    public function getByGroupId(int $groupId)
    {
        return Menu::whereHas('groups', function ($query) use ($groupId) {
            $query->whereKey($groupId);
        })->get();
    }
}
