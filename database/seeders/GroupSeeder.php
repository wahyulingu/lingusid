<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Parent group for system-level groups
            $system = Group::create([
                'name' => 'System',
                'description' => 'Grup induk untuk semua grup terkait sistem.',
            ]);

            // Group for article categories
            $articleCategory = Group::create([
                'name' => 'Kategori Artikel',
                'description' => 'Grup untuk kategori-kategori artikel.',
            ]);

            $neighborhoodGroup = Group::create([
                'name' => 'Lingkungan',
                'description' => 'Grup untuk konteks lingkungan.',
            ]);

            // Group for neighborhood contexts (RT/RW)
            $neighborhoodGroup = Group::create([
                'name' => 'Lingkungan',
                'description' => 'Grup untuk konteks lingkungan.',
            ]);

            // Group for chat groups
            $chatGroup = Group::create([
                'name' => 'Grup Obrolan',
                'description' => 'Grup untuk menampung grup-grup obrolan.',
            ]);

            // Assign the main groups as children of 'System'
            $system->children()->saveMany([
                $articleCategory,
                $neighborhoodGroup,
                $chatGroup,
            ]);

            // Create RT and RW groups under 'Grup Lingkungan'
            $rt = Group::create([
                'name' => 'RT',
                'description' => 'Grup untuk Rukun Tetangga.',
            ]);
            $rw = Group::create([
                'name' => 'RW',
                'description' => 'Grup untuk Rukun Warga.',
            ]);
            $neighborhoodGroup->children()->saveMany([$rt, $rw]);

            // Create specific chat groups under 'Grup Obrolan'
            $rtChat = Group::create([
                'name' => 'Obrolan RT',
                'description' => 'Grup obrolan untuk tingkat RT.',
            ]);
            $rwChat = Group::create([
                'name' => 'Obrolan RW',
                'description' => 'Grup obrolan untuk tingkat RW.',
            ]);
            $chatGroup->children()->saveMany([$rtChat, $rwChat]);
        });
    }
}
