<?php

namespace Tests\Feature\Sid\Village;

use App\Models\Sid\SidVillageIdentity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidVillageIdentityTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_village_identity_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/village/identity');

        $response->assertOk();
    }

    public function test_sid_village_identity_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $identity = SidVillageIdentity::factory()->create();

        $response = $this->post('/dashboard/sid/village/identity', [
            'village_name' => 'Updated Village Name',
            'village_code' => '12345',
            'district_name' => 'Updated District Name',
            'city_name' => 'Updated City Name',
            'province_name' => 'Updated Province Name',
            'village_head_name' => 'Updated Village Head Name',
            'village_head_nip' => '123456789012345678',
            'village_secretary_name' => 'Updated Village Secretary Name',
            'village_secretary_nip' => '123456789012345678',
            'village_treasurer_name' => 'Updated Village Treasurer Name',
            'village_treasurer_nip' => '123456789012345678',
        ]);

        $identity->refresh();

        $this->assertEquals('Updated Village Name', $identity->village_name);
        $this->assertEquals('12345', $identity->village_code);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
