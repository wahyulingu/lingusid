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
            'name' => 'Main Navigation',
            'slug' => Str::slug('Main Navigation'),
            'type' => 'menu_container',
            'description' => 'This group holds the main navigation menu items.',
        ]);
    }
}