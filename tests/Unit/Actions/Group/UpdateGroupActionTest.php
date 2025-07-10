<?php

namespace Tests\Unit\Actions\Group;

use App\Actions\Group\UpdateGroupAction;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(GroupRepository::class, $this->createMock(GroupRepository::class));
    }

    #[test]
    public function it_updates_a_group_with_valid_data(): void
    {
        $group = Group::factory()->make();
        $data = [
            'name' => 'Updated Name',
            'type' => 'updated_type',
            'url' => 'http://updated.com',
            'icon' => 'updated_icon',
        ];

        $this->mock(GroupRepository::class, function ($mock) use ($group, $data) {
            $mock->shouldReceive('update')
                ->once()
                ->andReturn(true);
        });

        $action = new UpdateGroupAction($this->app->make(GroupRepository::class));
        $updatedGroup = $action->execute(['group' => $group] + $data);

        $this->assertInstanceOf(Group::class, $updatedGroup);
        $this->assertEquals('Updated Name', $updatedGroup->name);
    }

    #[test]
    public function test_throws_validation_exception_for_invalid_data(): void
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $group = Group::factory()->make();
        $data = [
            'name' => '',
            'type' => 'updated_type',
        ];

        $action = new UpdateGroupAction($this->app->make(GroupRepository::class));
        $action->execute(['group' => $group] + $data);
    }
}
