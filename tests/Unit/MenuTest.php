<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_can_create_a_menu()
    {
        $menu = Menu::create([
            'name' => 'Dashboard',
            'url' => '/dashboard',
            'icon' => 'fa-home',
            'order' => 1,
        ]);

        $this->assertNotNull($menu);
        $this->assertEquals('Dashboard', $menu->name);
        $this->assertEquals('/dashboard', $menu->url);
        $this->assertEquals('fa-home', $menu->icon);
        $this->assertEquals(1, $menu->order);
    }

    #[Test]
    public function test_can_create_a_nested_menu()
    {
        $parentMenu = Menu::create([
            'name' => 'Settings',
            'url' => '/settings',
            'icon' => 'fa-cog',
            'order' => 2,
            'type' => 'main',
        ]);

        $childMenu = Menu::create([
            'name' => 'User Management',
            'url' => '/settings/users',
            'icon' => 'fa-users',
            'order' => 1,
            'parent_id' => $parentMenu->id,
            'type' => 'sub',
        ]);

        $this->assertNotNull($childMenu);
        $this->assertEquals($parentMenu->id, $childMenu->parent_id);
        $this->assertEquals('Settings', $childMenu->parent->name);
        $this->assertCount(1, $parentMenu->children);
        $this->assertEquals('User Management', $parentMenu->children->first()->name);
    }

    #[Test]
    public function test_menu_can_have_groups()
    {
        $menu = Menu::factory()->create();
        $group1 = Group::factory()->create();
        $group2 = Group::factory()->create();

        $menu->groups()->attach($group1);
        $menu->groups()->attach($group2);

        $this->assertCount(2, $menu->groups);
        $this->assertTrue($menu->groups->contains($group1));
        $this->assertTrue($menu->groups->contains($group2));
    }

    #[Test]
    public function test_menu_can_detach_groups()
    {
        $menu = Menu::factory()->create();
        $group1 = Group::factory()->create();
        $group2 = Group::factory()->create();

        $menu->groups()->attach($group1);
        $menu->groups()->attach($group2);

        $this->assertCount(2, $menu->groups);

        $menu->groups()->detach($group1);
        $menu->unsetRelation('groups'); // Use unsetRelation() instead of direct unset
        $menu->fresh(); // Reload the model to get updated relationships

        $this->assertCount(1, $menu->groups);
        $this->assertFalse($menu->groups->contains($group1));
        $this->assertTrue($menu->groups->contains($group2));
    }

    #[Test]
    public function test_menu_can_sync_groups()
    {
        $menu = Menu::factory()->create();
        $group1 = Group::factory()->create();
        $group2 = Group::factory()->create();
        $group3 = Group::factory()->create();

        $menu->groups()->attach($group1);
        $menu->groups()->attach($group2);

        $this->assertCount(2, $menu->groups);

        $menu->groups()->sync([$group2->id, $group3->id]);
        $menu->unsetRelation('groups'); // Use unsetRelation() instead of direct unset
        $menu->fresh(); // Reload the model to get updated relationships

        $this->assertCount(2, $menu->groups);
        $this->assertFalse($menu->groups->contains($group1));
        $this->assertTrue($menu->groups->contains($group2));
        $this->assertTrue($menu->groups->contains($group3));
    }
}
