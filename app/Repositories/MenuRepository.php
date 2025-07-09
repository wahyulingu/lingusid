<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository extends Repository
{
    /**
     * @var class-string<Menu>
     */
    protected $model = Menu::class;
}