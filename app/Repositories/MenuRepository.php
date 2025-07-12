<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository extends Repository
{
    /**
     * @var class-string<Menu>
     */
    protected $model = Menu::class;

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
