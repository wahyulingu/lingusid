<?php

namespace Tests\Unit\Actions\Menu;

use App\Actions\Menu\UpdateMenuAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateMenuActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(MenuRepository::class, $this->createMock(MenuRepository::class));
    }

    #[test]
    public function test_updates_a_menu_with_valid_data(): void
    {
        $menu = Menu::factory()->make();
        $data = [
            'name' => 'Updated Menu',
            'type' => 'footer',
            'url' => '/updated-menu',
            'icon' => 'updated-icon',
            'order' => 2,
        ];

        $this->mock(MenuRepository::class, function ($mock) use ($menu, $data) {
            $mock->shouldReceive('update')
                ->once()
                ->andReturn(true);
            $mock->shouldReceive('find')
                ->once()
                ->andReturn(new Menu($data));
        });

        $action = new UpdateMenuAction($this->app->make(MenuRepository::class));
        $updatedMenu = $action->execute(['menu' => $menu] + $data);

        $this->assertInstanceOf(Menu::class, $updatedMenu);
        $this->assertEquals('Updated Menu', $updatedMenu->name);
    }

    #[test]
    public function test_throws_validation_exception_for_invalid_data(): void
    {
        $this->expectException(ValidationException::class);

        $menu = Menu::factory()->make();
        $data = [
            'name' => '',
            'type' => 'footer',
        ];

        $action = new UpdateMenuAction($this->app->make(MenuRepository::class));
        $action->execute(['menu' => $menu] + $data);
    }
}
