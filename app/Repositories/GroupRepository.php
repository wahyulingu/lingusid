<?php

namespace App\Repositories;

use App\Abstractions\Repository\ModelRepository;
use Illuminate\Database\Eloquent\Builder;

class GroupRepository extends ModelRepository
{
    public function indexByParentId(?int $parentId = null)
    {
        return $this->query(fn (Builder $query) => $query->where('parent_id', $parentId));
    }
}
