<?php

namespace Tests\Feature\Web;

use App\Models\Web\WebGallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_gallery_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/web/galleries');

        $response->assertOk();
    }

    public function test_web_gallery_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/web/galleries', [
            'title' => 'Galeri Foto Desa',
            'slug' => 'galeri-foto-desa',
            'description' => 'Kumpulan foto kegiatan desa',
            'cover_image' => 'cover.jpg',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('web_galleries', [
            'title' => 'Galeri Foto Desa',
        ]);
    }

    public function test_web_gallery_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $gallery = WebGallery::factory()->create();

        $response = $this->put('/dashboard/web/galleries/'.$gallery->id, [
            'title' => 'Galeri Video Desa',
            'slug' => 'galeri-video-desa',
            'description' => 'Kumpulan video kegiatan desa',
            'cover_image' => 'new_cover.jpg',
        ]);

        $gallery->refresh();

        $this->assertEquals('Galeri Video Desa', $gallery->title);
        $this->assertEquals('galeri-video-desa', $gallery->slug);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_web_gallery_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $gallery = WebGallery::factory()->create();

        $response = $this->delete('/dashboard/web/galleries/'.$gallery->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('web_galleries', [
            'id' => $gallery->id,
        ]);
    }
}
