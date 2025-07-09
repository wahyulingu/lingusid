<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainNavigationGroup = Group::where('type', 'menu_container')
                                    ->where('name', 'Main Navigation')
                                    ->first();

        if ($mainNavigationGroup) {
            Menu::create([
                'name' => 'Manajemen Menu',
                'url' => '/menus',
                'icon' => 'List',
                'order' => 99,
                'group_id' => $mainNavigationGroup->id,
            ]);
        }
    }
}