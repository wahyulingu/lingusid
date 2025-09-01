<?php

namespace Tests\Feature\Web;

use App\Enums\System\GroupEnum;
use App\Models\Group;
use App\Models\User;
use App\Models\Web\WebArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WebArticleTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Group $categoryGroup;
    protected Group $articleCategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->categoryGroup = Group::factory()->create(['name' => GroupEnum::CONTENT_ARTICLE_CATEGORY->value]);
        $this->articleCategory = Group::factory()->create(['parent_id' => $this->categoryGroup->id]);
    }

    #[Test]
    public function user_can_view_articles_index(): void
    {
        $this->actingAs($this->user)
            ->get(route('dashboard.web.articles.index'))
            ->assertOk();
    }

    #[Test]
    public function user_can_create_article(): void
    {
        $this->actingAs($this->user)
            ->post(route('dashboard.web.articles.store'), [
                'title' => 'Test Article',
                'slug' => 'test-article',
                'content' => 'This is a test article content.',
                'published_at' => now()->format('Y-m-d H:i:s'),
                'author_id' => $this->user->id,
                'group_id' => $this->articleCategory->id,
            ])
            ->assertRedirect(route('dashboard.web.articles.index'));

        $this->assertDatabaseHas('web_articles', [
            'title' => 'Test Article',
            'slug' => 'test-article',
            'content' => 'This is a test article content.',
            'author_id' => $this->user->id,
        ]);

        $article = WebArticle::where('slug', 'test-article')->first();
        $this->assertCount(1, $article->groups);
        $this->assertEquals($this->articleCategory->id, $article->groups->first()->id);
    }

    #[Test]
    public function user_can_update_article(): void
    {
        $article = WebArticle::factory()->create(['author_id' => $this->user->id]);
        $article->groups()->attach($this->articleCategory->id);

        $newCategory = Group::factory()->create(['parent_id' => $this->categoryGroup->id]);

        $this->actingAs($this->user)
            ->put(route('dashboard.web.articles.update', $article->id), [
                'title' => 'Updated Article',
                'slug' => 'updated-article',
                'content' => 'This is updated article content.',
                'published_at' => now()->format('Y-m-d H:i:s'),
                'author_id' => $this->user->id,
                'group_id' => $newCategory->id,
            ])
            ->assertRedirect(route('dashboard.web.articles.index'));

        $this->assertDatabaseHas('web_articles', [
            'id' => $article->id,
            'title' => 'Updated Article',
            'slug' => 'updated-article',
            'content' => 'This is updated article content.',
        ]);

        $updatedArticle = WebArticle::find($article->id);
        $this->assertCount(1, $updatedArticle->groups);
        $this->assertEquals($newCategory->id, $updatedArticle->groups->first()->id);
    }

    #[Test]
    public function user_can_delete_article(): void
    {
        $article = WebArticle::factory()->create(['author_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->delete(route('dashboard.web.articles.destroy', $article->id))
            ->assertRedirect(route('dashboard.web.articles.index'));

        $this->assertDatabaseMissing('web_articles', [
            'id' => $article->id,
        ]);
    }
}
