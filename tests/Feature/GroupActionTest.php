<?php

namespace Tests\Feature;

use App\Actions\Group\CreateGroupAction;
use App\Actions\Group\DeleteGroupAction;
use App\Actions\Group\UpdateGroupAction;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupActionTest extends TestCase
{
    use RefreshDatabase;

    #[test]
    public function test_can_create_a_group(): void
    {
        $data = [
            'name' => 'Test Group',
            'type' => 'test_type',
            'url' => 'http://example.com',
            'icon' => 'test_icon',
            'description' => fake()->sentence(),
        ];

        $group = CreateGroupAction::handle($data);

        $this->assertInstanceOf(Group::class, $group);
        $this->assertDatabaseHas('groups', [
            'name' => 'Test Group',
            'slug' => 'test-group',
        ]);
    }

    #[test]
    public function test_can_update_a_group(): void
    {
        $group = Group::factory()->create([
            'name' => 'Original Name',
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'url' => 'http://updated.com',
            'icon' => 'updated_icon',
        ];

        $updatedGroup = UpdateGroupAction::handle(['id' => $group->getKey()] + $updateData);

        $this->assertInstanceOf(Group::class, $updatedGroup);
        $this->assertEquals('Updated Name', $updatedGroup->name);
        $this->assertDatabaseHas('groups', [
            'id' => $group->getKey(),
            'name' => 'Updated Name',
        ]);
    }

    #[test]
    public function test_can_delete_a_group(): void
    {
        $group = Group::factory()->create();

        DeleteGroupAction::handle(['group' => $group]);

        $this->assertDatabaseMissing('groups', [
            'id' => $group->id,
        ]);
    }
}
