<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::factory()->create([
            'name' => 'Super Admin',
        ]);
        Group::factory()->count(4)->create();
    }
}
