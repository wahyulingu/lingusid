<?php

namespace Tests\Unit\Actions\Menu;

use App\Actions\Menu\DeleteMenuByIdAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteMenuActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(MenuRepository::class, $this->createMock(MenuRepository::class));
    }

    #[Test]
    public function test_deletes_a_menu(): void
    {
        $menu = Menu::factory()->create();

        $this->mock(MenuRepository::class, function ($mock) use ($menu) {
            $mock->shouldReceive('delete')
                ->once()
                ->with($menu->getKey())
                ->andReturn(true);
        });

        $action = new DeleteMenuByIdAction($this->app->make(MenuRepository::class));
        $result = $action->execute(['id' => $menu->getKey()]);

        $this->assertTrue($result);
    }
}
