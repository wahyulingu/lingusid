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
        $superAdminGroup = Group::where('name', 'Super Admin')->first();

        $webMenu = Menu::factory()->create([
            'name' => 'Web',
            'url' => '#',
            'type' => 'main',
        ]);

        $menuSubMenu = Menu::factory()->create([
            'name' => 'Menu',
            'url' => route('dashboard.web.menu.index'),
            'parent_id' => $webMenu->id,
            'type' => 'sub',
        ]);

        $webMenu->groups()->attach($superAdminGroup);
        $menuSubMenu->groups()->attach($superAdminGroup);
    }
}
