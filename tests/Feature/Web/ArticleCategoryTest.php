<?php

namespace Tests\Feature\Web;

use App\Enums\System\GroupEnum;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ArticleCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Group $categoryGroup;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->categoryGroup = Group::factory()->create(['name' => GroupEnum::CONTENT_ARTICLE_CATEGORY->value]);
    }

    #[Test]
    public function user_can_view_article_categories_index(): void
    {
        $this->actingAs($this->user)
            ->get(route('dashboard.web.article-categories.index'))
            ->assertOk();
    }

    #[Test]
    public function user_can_create_article_category(): void
    {
        $this->actingAs($this->user)
            ->post(route('dashboard.web.article-categories.store'), [
                'name' => 'Test Category',
                'description' => 'This is a test category.',
            ])
            ->assertRedirect(route('dashboard.web.article-categories.index'));

        $this->assertDatabaseHas('groups', [
            'name' => 'Test Category',
            'description' => 'This is a test category.',
        ]);

        $category = Group::where('name', 'Test Category')->first();
        $this->assertCount(1, $category->groups);
        $this->assertEquals($this->categoryGroup->id, $category->groups->first()->id);
    }

    #[Test]
    public function user_can_update_article_category(): void
    {
        $category = Group::factory()->create();
        $this->categoryGroup->groups()->attach($category->id);

        $this->actingAs($this->user)
            ->put(route('dashboard.web.article-categories.update', $category->id), [
                'name' => 'Updated Category',
                'description' => 'This is an updated category.',
            ])
            ->assertRedirect(route('dashboard.web.article-categories.index'));

        $this->assertDatabaseHas('groups', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'description' => 'This is an updated category.',
        ]);
    }

    #[Test]
    public function user_can_delete_article_category(): void
    {
        $category = Group::factory()->create();
        $this->categoryGroup->groups()->attach($category->id);

        $this->actingAs($this->user)
            ->delete(route('dashboard.web.article-categories.destroy', $category->id))
            ->assertRedirect(route('dashboard.web.article-categories.index'));

        $this->assertDatabaseMissing('groups', [
            'id' => $category->id,
        ]);
    }
}
