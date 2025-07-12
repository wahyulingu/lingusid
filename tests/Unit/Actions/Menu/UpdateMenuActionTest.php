<?php

namespace Tests\Unit\Actions\Menu;

use App\Actions\Menu\UpdateMenuAction;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateMenuActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(MenuRepository::class, $this->createMock(MenuRepository::class));
    }

    #[Test]
    public function test_updates_a_menu_with_valid_data(): void
    {
        $menu = Menu::factory()->create();
        $data = [
            'name' => 'Updated Menu',
            'url' => '/updated-menu',
            'icon' => 'updated-icon',
            'order' => 2,
        ];

        $this->mock(MenuRepository::class, function ($mock) use ($menu) {
            $mock->shouldReceive('update')
                ->once()
                ->andReturnUsing(function ($id, $attributes) use ($menu) {
                    $menu->fill($attributes);

                    return $menu;
                });
        });

        $action = new UpdateMenuAction($this->app->make(MenuRepository::class));
        $updatedMenu = $action->execute(['id' => $menu->getKey()] + $data);

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
        ];

        $action = new UpdateMenuAction($this->app->make(MenuRepository::class));
        $action->execute(['id' => $menu->getKey()] + $data);
    }
}
