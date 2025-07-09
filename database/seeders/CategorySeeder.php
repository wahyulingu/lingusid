<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all menus from the old table
        $menus = Menu::all();

        foreach ($menus as $menu) {
            Category::create([
                'id' => $menu->id,
                'name' => $menu->name,
                'slug' => Str::slug($menu->name),
                'type' => 'menu',
                'description' => json_encode(['url' => $menu->url, 'icon' => $menu->icon]),
                'parent_id' => $menu->parent_id,
            ]);
        }
    }
}