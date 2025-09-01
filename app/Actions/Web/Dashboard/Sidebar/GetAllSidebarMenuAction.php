<?php

namespace App\Actions\Web\Dashboard\Sidebar;

use App\Abstractions\Actions\Action;
use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Enums\System\GroupEnum;
use App\Repositories\MenuRepository;
use Illuminate\Support\Collection;

class GetAllSidebarMenuAction extends Action
{
    public function __construct(
        protected readonly EnsureSystemGroupExistsAction $ensureSystemGroupExists,
        protected readonly MenuRepository $menuRepository,
    ) {}

    /**
     * @param  null  $payload  Tidak digunakan.
     * @param  array  $validatedPayload  Payload terverifikasi (jika validasi diaktifkan).
     */
    protected function handler($payload = null, array $validatedPayload = []): Collection
    {
        /**
         * @var \App\Models\Group $sidebarMenuGroup
         */
        $sidebarMainMenuGroup = $this

            ->ensureSystemGroupExists
            ->execute(GroupEnum::DASHBOARD_SIDEBAR_MENU->value);

        $sidebarMenu = $this

            ->menuRepository
            ->getAllSidebarMenu($sidebarMainMenuGroup->getKey());

        return $sidebarMenu;
    }
}
