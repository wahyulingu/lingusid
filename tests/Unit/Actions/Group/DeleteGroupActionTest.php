<?php

namespace Tests\Unit\Actions\Group;

use App\Actions\Group\DeleteGroupAction;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance(GroupRepository::class, $this->createMock(GroupRepository::class));
    }

    #[Test]
    public function can_deletes_a_group(): void
    {
        $group = Group::factory()->make();

        $this->mock(GroupRepository::class, function ($mock) use ($group) {
            $mock->shouldReceive('delete')
                ->once()
                ->with($group->id)
                ->andReturn(true);
        });

        $action = new DeleteGroupAction($this->app->make(GroupRepository::class));
        $result = $action->execute(['group' => $group]);

        $this->assertTrue($result);
    }
}
