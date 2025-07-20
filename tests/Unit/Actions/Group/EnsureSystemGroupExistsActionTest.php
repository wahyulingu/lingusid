<?php

namespace Tests\Unit\Actions\Group;

use App\Actions\Group\CreateGroupAction;
use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EnsureSystemGroupExistsActionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_handle_with_invalid_group_key_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected string groupKey for group slug.');

        $groupRepository = Mockery::mock(GroupRepository::class);
        $createGroupAction = Mockery::mock(CreateGroupAction::class);

        $action = new EnsureSystemGroupExistsAction($groupRepository, $createGroupAction);
        $action->handle(123);
    }

    #[Test]
    public function test_handle_with_existing_group_returns_group()
    {
        $groupKey = 'test-group';
        $slug = Str::of($groupKey)->start(EnsureSystemGroupExistsAction::SYSTEM_GROUP_PREFIX)->slug()->toString();

        $group = Group::factory()->create(['slug' => $slug]);

        $groupRepository = Mockery::mock(GroupRepository::class);
        $groupRepository->shouldReceive('index')->with(['filters' => ['slug' => $slug]])->andReturn(collect([$group]));

        $createGroupAction = Mockery::mock(CreateGroupAction::class);

        $action = new EnsureSystemGroupExistsAction($groupRepository, $createGroupAction);
        $result = $action->handle($groupKey);

        $this->assertInstanceOf(Group::class, $result);
        $this->assertEquals($group->id, $result->id);
    }

    #[Test]
    public function test_handle_with_non_existing_group_creates_and_returns_group()
    {
        $groupKey = 'new-group';
        $slug = Str::of($groupKey)->start(EnsureSystemGroupExistsAction::SYSTEM_GROUP_PREFIX)->slug()->toString();
        $name = Str::of($slug)->replace('-', ' ')->title()->toString();
        $description = sprintf('This group is for the %s functionalities.', Str::lower($name));

        $groupRepository = Mockery::mock(GroupRepository::class);
        $groupRepository->shouldReceive('index')->with(['filters' => ['slug' => $slug]])->andReturn(collect([]));

        $newGroup = Group::factory()->make(['name' => $name, 'description' => $description]);

        $createGroupAction = Mockery::mock(CreateGroupAction::class);
        $createGroupAction->shouldReceive('handle')->with(compact('name', 'description'))->andReturn($newGroup);

        $action = new EnsureSystemGroupExistsAction($groupRepository, $createGroupAction);
        $result = $action->handle($groupKey);

        $this->assertInstanceOf(Group::class, $result);
        $this->assertEquals($name, $result->name);
        $this->assertEquals($description, $result->description);
    }
}
