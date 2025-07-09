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
        $groups = Group::factory()->count(3)->create();

        Menu::factory()->count(10)->create()->each(function ($menu) use ($groups) {
            $menu->groups()->attach($groups->random(1));
        });
    }
}