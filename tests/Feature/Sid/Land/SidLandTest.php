<?php

namespace Tests\Feature\Sid\Land;

use App\Models\Sid\SidLand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidLandTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_land_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/lands/lands');

        $response->assertOk();
    }

    public function test_sid_land_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/lands/lands', [
            'owner_name' => 'Budi Santoso',
            'land_area' => 150.50,
            'land_address' => 'Jl. Kebun Raya No. 10',
            'land_type' => 'kebun',
            'certificate_number' => 'CERT-2024-001',
            'description' => 'Lahan kebun produktif',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_lands', [
            'owner_name' => 'Budi Santoso',
            'land_area' => 150.50,
        ]);
    }

    public function test_sid_land_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $land = SidLand::factory()->create();

        $response = $this->put('/dashboard/sid/lands/lands/'.$land->id, [
            'owner_name' => 'Siti Aminah',
            'land_area' => 200.75,
            'land_address' => 'Jl. Sawah Indah No. 5',
            'land_type' => 'sawah',
            'certificate_number' => 'CERT-2024-002',
            'description' => 'Sawah irigasi teknis',
        ]);

        $land->refresh();

        $this->assertEquals('Siti Aminah', $land->owner_name);
        $this->assertEquals(200.75, $land->land_area);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_land_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $land = SidLand::factory()->create();

        $response = $this->delete('/dashboard/sid/lands/lands/'.$land->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_lands', [
            'id' => $land->id,
        ]);
    }
}
