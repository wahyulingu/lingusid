<?php

namespace Tests\Feature\Sid\Village;

use App\Models\Sid\SidVillageArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidVillageAreaTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_village_area_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/village/areas');

        $response->assertOk();
    }

    public function test_sid_village_area_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/village/areas', [
            'name' => 'Dusun A',
            'code' => 'DSA',
            'description' => 'Description for Dusun A',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_village_areas', [
            'name' => 'Dusun A',
            'code' => 'DSA',
        ]);
    }

    public function test_sid_village_area_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $area = SidVillageArea::factory()->create();

        $response = $this->put('/dashboard/sid/village/areas/'.$area->id, [
            'name' => 'Dusun B',
            'code' => 'DSB',
            'description' => 'Description for Dusun B',
        ]);

        $area->refresh();

        $this->assertEquals('Dusun B', $area->name);
        $this->assertEquals('DSB', $area->code);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_village_area_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $area = SidVillageArea::factory()->create();

        $response = $this->delete('/dashboard/sid/village/areas/'.$area->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_village_areas', [
            'id' => $area->id,
        ]);
    }
}
