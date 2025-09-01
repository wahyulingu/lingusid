<?php

namespace Tests\Feature\Sid\Village;

use App\Models\Sid\SidVillageGovernment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidVillageGovernmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_village_government_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/village/government');

        $response->assertOk();
    }

    public function test_sid_village_government_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/village/government', [
            'name' => 'John Doe',
            'position' => 'Kepala Desa',
            'nip' => '123456789012345678',
            'start_date' => '2020-01-01',
            'end_date' => '2024-12-31',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_village_governments', [
            'name' => 'John Doe',
            'position' => 'Kepala Desa',
        ]);
    }

    public function test_sid_village_government_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $government = SidVillageGovernment::factory()->create();

        $response = $this->put('/dashboard/sid/village/government/'.$government->id, [
            'name' => 'Jane Doe',
            'position' => 'Sekretaris Desa',
            'nip' => '123456789012345678',
            'start_date' => '2020-01-01',
            'end_date' => '2024-12-31',
        ]);

        $government->refresh();

        $this->assertEquals('Jane Doe', $government->name);
        $this->assertEquals('Sekretaris Desa', $government->position);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_village_government_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $government = SidVillageGovernment::factory()->create();

        $response = $this->delete('/dashboard/sid/village/government/'.$government->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_village_governments', [
            'id' => $government->id,
        ]);
    }
}
