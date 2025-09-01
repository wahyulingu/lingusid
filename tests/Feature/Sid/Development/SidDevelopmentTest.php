<?php

namespace Tests\Feature\Sid\Development;

use App\Models\Sid\SidDevelopment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidDevelopmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_development_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/development/developments');

        $response->assertOk();
    }

    public function test_sid_development_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/development/developments', [
            'title' => 'Pembangunan Balai Desa',
            'description' => 'Pembangunan balai desa baru',
            'location' => 'Pusat Desa',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'budget' => 50000000.00,
            'status' => 'in_progress',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_developments', [
            'title' => 'Pembangunan Balai Desa',
        ]);
    }

    public function test_sid_development_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $development = SidDevelopment::factory()->create();

        $response = $this->put('/dashboard/sid/development/developments/'.$development->id, [
            'title' => 'Perbaikan Jalan',
            'description' => 'Perbaikan jalan utama desa',
            'location' => 'Jalan Raya',
            'start_date' => '2024-03-01',
            'end_date' => '2024-06-30',
            'budget' => 25000000.00,
            'status' => 'completed',
        ]);

        $development->refresh();

        $this->assertEquals('Perbaikan Jalan', $development->title);
        $this->assertEquals('completed', $development->status);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_development_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $development = SidDevelopment::factory()->create();

        $response = $this->delete('/dashboard/sid/development/developments/'.$development->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_developments', [
            'id' => $development->id,
        ]);
    }
}
