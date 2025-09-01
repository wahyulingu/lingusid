<?php

namespace App\Repositories;

use App\Abstractions\Repository\ModelRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuRepository extends ModelRepository
{
    public function getAllSidebarMenu(int $sidebarGroupId)
    {
        $sidebarMenu = $this->query(function (Builder $menu) use ($sidebarGroupId) {

            $menu->whereNull('parent_id');
            $menu->whereHas('groups', function (Builder $group) use ($sidebarGroupId) {
                $group->whereKey($sidebarGroupId);
                $group->orWhereHas('groups', fn (Builder $parent) => $parent->whereKey($sidebarGroupId));
            });

            $menu->with(['groups', 'groups.metadata']);
            $menu->with(['children' => fn (HasMany $children) => $children->orderBy('order')]);

            $menu->orderBy('order');
        });

        return $sidebarMenu->get();
    }
}
