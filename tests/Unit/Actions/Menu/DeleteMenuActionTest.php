<?php

namespace Tests\Unit\Actions\Menu;

use App\Actions\Menu\DeleteMenuAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteMenuActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(MenuRepository::class, $this->createMock(MenuRepository::class));
    }

    #[test]
    public function test_deletes_a_menu(): void
    {
        $menu = Menu::factory()->make();

        $this->mock(MenuRepository::class, function ($mock) use ($menu) {
            $mock->shouldReceive('delete')
                ->once()
                ->with($menu->id)
                ->andReturn(true);
        });

        $action = new DeleteMenuAction($this->app->make(MenuRepository::class));
        $result = $action->execute(['menu' => $menu]);

        $this->assertTrue($result);
    }
}
