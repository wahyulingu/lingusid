<?php

namespace Tests\Feature;

use App\Actions\Menu\CreateMenuAction;
use App\Actions\Menu\UpdateMenuAction;
use App\Models\Group;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MenuActionTest extends TestCase
{
    use RefreshDatabase;

    #[test]
    public function test_can_create_a_menu(): void
    {
        $data = [
            'name' => 'Test Menu',
            'url' => '/test-menu',
            'icon' => 'test-icon',
            'order' => 1,
        ];

        $menu = CreateMenuAction::handle($data);

        $this->assertInstanceOf(Menu::class, $menu);
        $this->assertDatabaseHas('menus', ['name' => 'Test Menu']);
    }

    #[test]
    public function test_can_update_a_menu(): void
    {
        $menu = Menu::factory()->create([
            'name' => 'Original Menu',
        ]);

        $updateData = [
            'name' => 'Updated Menu',
            'url' => '/updated-menu',
            'icon' => 'updated-icon',
            'order' => 2,
        ];

        $updatedMenu = UpdateMenuAction::handle(['id' => $menu->getKey()] + $updateData);

        $this->assertInstanceOf(Menu::class, $updatedMenu);
        $this->assertEquals('Updated Menu', $updatedMenu->name);
        $this->assertDatabaseHas('menus', [
            'id' => $menu->getKey(),
            'name' => 'Updated Menu',
        ]);
    }

    #[test]
    public function menu_can_have_parent_and_children_relationships(): void
    {
        $parentMenu = Menu::factory()->create(['name' => 'Parent Menu']);
        $childMenu = CreateMenuAction::handle([
            'name' => 'Child Menu',
            'parent_id' => $parentMenu->id,
        ]);

        $this->assertEquals($parentMenu->id, $childMenu->parent_id);
        $this->assertTrue($parentMenu->children->contains($childMenu));

        // Update child to change parent
        $newParentMenu = Menu::factory()->create(['name' => 'New Parent Menu']);
        UpdateMenuAction::handle([
            'id' => $childMenu->getKey(),
            'name' => 'Child Menu Updated',
            'parent_id' => $newParentMenu->id,
        ]);

        $childMenu->refresh();
        $this->assertEquals($newParentMenu->id, $childMenu->parent_id);
        $newParentMenu->refresh(); // Refresh the new parent to get updated children
        $this->assertTrue($newParentMenu->children->contains($childMenu));
        $parentMenu->refresh(); // Refresh the old parent to get updated children
        $this->assertFalse($parentMenu->children->contains($childMenu)); // Old parent should no longer have this child
    }

    #[test]
    public function deleting_parent_menu_cascades_to_children(): void
    {
        $parentMenu = Menu::factory()->create(['name' => 'Parent Menu']);
        $childMenu = CreateMenuAction::handle([
            'name' => 'Child Menu',
            'parent_id' => $parentMenu->id,
        ]);

        $grandchildMenu = CreateMenuAction::handle([
            'name' => 'Grandchild Menu',
            'parent_id' => $childMenu->id,
        ]);

        $parentMenu->delete();

        $this->assertDatabaseMissing('menus', ['id' => $parentMenu->id]);
        $this->assertDatabaseMissing('menus', ['id' => $childMenu->id]);
        $this->assertDatabaseMissing('menus', ['id' => $grandchildMenu->id]);
    }

    #[test]
    public function menu_can_be_associated_with_groups(): void
    {
        $menu = Menu::factory()->create();
        $group1 = \App\Models\Group::factory()->create(['name' => 'Group One']);
        $group2 = \App\Models\Group::factory()->create(['name' => 'Group Two']);

        // Attach groups
        $menu->groups()->attach($group1->id);
        $menu->groups()->attach($group2->id);
        $menu->refresh();

        $this->assertTrue($menu->groups->contains($group1));
        $this->assertTrue($menu->groups->contains($group2));
        $this->assertCount(2, $menu->groups);

        // Detach a group
        $menu->groups()->detach($group1->id);
        $menu->refresh();

        $this->assertFalse($menu->groups->contains($group1));
        $this->assertTrue($menu->groups->contains($group2));
        $this->assertCount(1, $menu->groups);

        // Sync groups
        $group3 = \App\Models\Group::factory()->create(['name' => 'Group Three']);
        $menu->groups()->sync([$group2->id, $group3->id]);
        $menu->refresh();

        $this->assertTrue($menu->groups->contains($group2));
        $this->assertTrue($menu->groups->contains($group3));
        $this->assertFalse($menu->groups->contains($group1));
        $this->assertCount(2, $menu->groups);
    }
}
