<?php

namespace Tests\Unit\Actions\Group;

use App\Actions\Group\CreateGroupAction;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(GroupRepository::class, $this->createMock(GroupRepository::class));
    }

    #[Test]
    public function it_creates_a_group_with_valid_data(): void
    {
        $data = [
            'name' => 'Test Group',
            'description' => 'Ea est dolor consequatur cum rerum.',
            'type' => 'test_type',
            'url' => 'http://example.com',
            'icon' => 'test_icon',
        ];

        $this->mock(GroupRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('store')
                ->once()
                ->andReturn(new Group($data));
        });

        $action = new CreateGroupAction($this->app->make(GroupRepository::class));
        $group = $action->execute($data);

        $this->assertInstanceOf(Group::class, $group);
        $this->assertEquals('Test Group', $group->name);
    }

    #[test]
    public function test_throws_validation_exception_for_invalid_data(): void
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $data = [
            'name' => '',
            'type' => 'test_type',
        ];

        $action = new CreateGroupAction($this->app->make(GroupRepository::class));
        $action->execute($data);
    }
}
