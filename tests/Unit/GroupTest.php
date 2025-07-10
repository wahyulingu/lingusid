<?php

namespace Tests\Unit;

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
        $this->assertEquals('general', $group->type);
        $this->assertEquals('A general test group', $group->description);
    }

    #[Test]
    public function test_can_create_a_nested_group()
    {
        $parentGroup = Group::create([
            'name' => 'Parent Group',
            'slug' => 'parent-group',
            'type' => 'category',
            'description' => 'A parent category group',
        ]);

        $childGroup = Group::create([
            'name' => 'Child Group',
            'slug' => 'child-group',
            'type' => 'subcategory',
            'description' => 'A child subcategory group',
            'parent_id' => $parentGroup->id,
        ]);

        $this->assertNotNull($childGroup);
        $this->assertEquals($parentGroup->id, $childGroup->parent_id);
        $this->assertEquals('Parent Group', $childGroup->parent->name);
        $this->assertCount(1, $parentGroup->children);
        $this->assertEquals('Child Group', $parentGroup->children->first()->name);
    }

    #[Test]
    public function test_group_relationships()
    {
        $parentGroup = Group::create([
            'name' => 'Parent Group',
            'slug' => 'parent-group',
            'type' => 'category',
            'description' => 'A parent category group',
        ]);

        $childGroup1 = Group::create([
            'name' => 'Child Group 1',
            'slug' => 'child-group-1',
            'type' => 'subcategory',
            'description' => 'A child subcategory group 1',
            'parent_id' => $parentGroup->id,
        ]);

        $childGroup2 = Group::create([
            'name' => 'Child Group 2',
            'slug' => 'child-group-2',
            'type' => 'subcategory',
            'description' => 'A child subcategory group 2',
            'parent_id' => $parentGroup->id,
        ]);

        $this->assertTrue($parentGroup->children->contains($childGroup1));
        $this->assertTrue($parentGroup->children->contains($childGroup2));
        $this->assertEquals($parentGroup->id, $childGroup1->parent->id);
        $this->assertEquals($parentGroup->id, $childGroup2->parent->id);
    }
}
