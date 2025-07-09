<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
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
            MenuItem::create([
                'name' => 'Manajemen Menu',
                'url' => '/menus',
                'icon' => 'List',
                'order' => 99,
                'group_id' => $mainNavigationGroup->id,
            ]);
        }
    }
}