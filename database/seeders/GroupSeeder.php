<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'Manajemen Menu',
            'slug' => Str::slug('Manajemen Menu'),
            'type' => 'menu',
            'description' => json_encode(['url' => '/menus', 'icon' => 'List']),
        ]);
    }
}
