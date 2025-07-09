<?php

namespace App\Repositories;

use App\Models\MenuItem;

class MenuItemRepository extends Repository
{
    /**
     * @var class-string<MenuItem>
     */
    protected $model = MenuItem::class;
}
