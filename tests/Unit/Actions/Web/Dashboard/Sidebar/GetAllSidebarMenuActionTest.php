<?php

namespace Tests\Unit\Actions\Web\Dashboard\Sidebar;

use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Actions\Web\Dashboard\Sidebar\GetAllSidebarMenuAction;
use App\Enums\System\GroupEnum;
use App\Repositories\GroupRepository;
use App\Repositories\MenuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetAllSidebarMenuActionTest extends TestCase
{
    use RefreshDatabase;

    protected MockInterface|EnsureSystemGroupExistsAction $ensureSystemGroupExistsAction;

    protected MockInterface|MenuRepository $menuRepository;

    protected MockInterface|GroupRepository $groupRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureSystemGroupExistsAction = $this->mock(EnsureSystemGroupExistsAction::class);
        $this->menuRepository = $this->mock(MenuRepository::class);
        $this->groupRepository = $this->mock(GroupRepository::class);
    }

    #[Test]
    public function it_should_return_all_sidebar_menus(): void
    {
        $group = EnsureSystemGroupExistsAction::handle(groupEnum::DASHBOARD_SIDEBAR_MENU->value);

        $this->ensureSystemGroupExistsAction
            ->shouldReceive('execute')
            ->once()
            ->with(GroupEnum::DASHBOARD_SIDEBAR_MENU->value)
            ->andReturn($group);

        $action = new GetAllSidebarMenuAction(
            $this->ensureSystemGroupExistsAction,
            $this->menuRepository,
            $this->groupRepository
        );

        $result = $action->execute();
    }
}
