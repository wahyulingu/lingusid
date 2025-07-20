<?php

namespace Tests\Unit;

use App\Actions\Group\AddGroupChildAction;
use App\Exceptions\Model\Group\CircularMembershipException;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_can_create_a_group()
    {
        $group = Group::create([
            'name' => 'Test Group',
            'slug' => 'test-group',
            'type' => 'general',
            'description' => 'A general test group',
        ]);

        $this->assertNotNull($group);
        $this->assertEquals('Test Group', $group->name);
        $this->assertEquals('test-group', $group->slug);
        $this->assertEquals('A general test group', $group->description);
    }

    #[Test]
    public function test_cannot_add_a_group_as_a_member_if_it_creates_a_circular_membership()
    {
        $groupA = Group::factory()->create();
        $groupB = Group::factory()->create();

        $action = $this->app->make(AddGroupChildAction::class);

        // Add B to A
        $action->execute($groupA, $groupB);

        $this->expectException(CircularMembershipException::class);

        // Try to add A to B (which should fail)
        $action->execute($groupB, $groupA);
    }
}
