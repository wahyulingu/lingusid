<?php

namespace Database\Seeders;

use App\Actions\Group\EnsureSystemGroupExistsAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(EnsureSystemGroupExistsAction $ensureSystemGroupExists): void
    {
        DB::transaction(function () use ($ensureSystemGroupExists) {

            $ensureSystemGroupExists->execute('dashboard sidebar menu');
            $ensureSystemGroupExists->execute('content article category');

        });
    }
}
