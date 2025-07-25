<?php

namespace Database\Seeders;

use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Enums\System\GroupEnum;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\progress;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(EnsureSystemGroupExistsAction $ensureSystemGroupExistsAction): void
    {
        $mainGroup = $ensureSystemGroupExistsAction->execute('main');

        DB::transaction(function () use ($ensureSystemGroupExistsAction, $mainGroup) {
            progress(
                label  : '⏳ Menyiapkan grup sistem',
                steps  : GroupEnum::cases(),          // iterable = total langkah
                callback: function ($groupEnum) use ($ensureSystemGroupExistsAction, $mainGroup) {
                    $mainGroup

                        ->morph(Group::class)
                        ->save($ensureSystemGroupExistsAction->handle($groupEnum->value));
                }
            );
        });
    }
}
