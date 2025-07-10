<?php

namespace Tests\Unit\Actions\Menu;

use App\Actions\Menu\CreateMenuAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateMenuActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(MenuRepository::class, $this->createMock(MenuRepository::class));
    }

    #[test]
    public function test_creates_a_menu_with_valid_data(): void
    {
        $data = [
            'name' => 'Test Menu',
            'type' => 'main',
            'url' => '/test-menu',
            'icon' => 'test-icon',
            'order' => 1,
        ];

        $this->mock(MenuRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('store')
                ->once()
                ->andReturn(new Menu($data));
        });

        $action = new CreateMenuAction($this->app->make(MenuRepository::class));
        $menu = $action->execute($data);

        $this->assertInstanceOf(Menu::class, $menu);
        $this->assertEquals('Test Menu', $menu->name);
    }

    #[test]
    public function test_throws_validation_exception_for_invalid_data(): void
    {
        $this->expectException(ValidationException::class);

        $data = [
            'name' => '',
            'type' => 'main',
        ];

        $action = new CreateMenuAction($this->app->make(MenuRepository::class));
        $action->execute($data);
    }
}
