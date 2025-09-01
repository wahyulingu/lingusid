<?php

namespace Tests\Feature\Web;

use App\Models\Web\WebPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_page_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/web/pages');

        $response->assertOk();
    }

    public function test_web_page_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/web/pages', [
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => 'Content of about us page',
            'published_at' => '2024-01-01 10:00:00',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('web_pages', [
            'title' => 'About Us',
        ]);
    }

    public function test_web_page_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $page = WebPage::factory()->create();

        $response = $this->put('/dashboard/web/pages/'.$page->id, [
            'title' => 'Contact Us',
            'slug' => 'contact-us',
            'content' => 'Content of contact us page',
            'published_at' => '2024-02-01 11:00:00',
        ]);

        $page->refresh();

        $this->assertEquals('Contact Us', $page->title);
        $this->assertEquals('contact-us', $page->slug);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_web_page_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $page = WebPage::factory()->create();

        $response = $this->delete('/dashboard/web/pages/'.$page->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('web_pages', [
            'id' => $page->id,
        ]);
    }
}
