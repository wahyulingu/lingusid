<?php

namespace Tests\Feature\Sid\Village;

use App\Models\Sid\SidVillageInstitution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidVillageInstitutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_village_institution_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/village/institutions');

        $response->assertOk();
    }

    public function test_sid_village_institution_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/village/institutions', [
            'name' => 'Lembaga Adat',
            'code' => 'LA',
            'description' => 'Description for Lembaga Adat',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_village_institutions', [
            'name' => 'Lembaga Adat',
            'code' => 'LA',
        ]);
    }

    public function test_sid_village_institution_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $institution = SidVillageInstitution::factory()->create();

        $response = $this->put('/dashboard/sid/village/institutions/'.$institution->id, [
            'name' => 'Lembaga Desa Baru',
            'code' => 'LDB',
            'description' => 'Description for Lembaga Desa Baru',
        ]);

        $institution->refresh();

        $this->assertEquals('Lembaga Desa Baru', $institution->name);
        $this->assertEquals('LDB', $institution->code);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_village_institution_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $institution = SidVillageInstitution::factory()->create();

        $response = $this->delete('/dashboard/sid/village/institutions/'.$institution->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_village_institutions', [
            'id' => $institution->id,
        ]);
    }
}
