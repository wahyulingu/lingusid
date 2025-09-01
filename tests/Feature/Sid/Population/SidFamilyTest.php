<?php

namespace Tests\Feature\Sid\Population;

use App\Models\Sid\SidFamily;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidFamilyTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_family_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/population/families');

        $response->assertOk();
    }

    public function test_sid_family_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/population/families', [
            'kk_number' => '1234567890123456',
            'head_of_family_nik' => '1234567890123456',
            'address' => 'Jl. Contoh No. 1',
            'rt' => '001',
            'rw' => '001',
            'village' => 'Desa Contoh',
            'district' => 'Kecamatan Contoh',
            'city' => 'Kota Contoh',
            'province' => 'Provinsi Contoh',
            'postal_code' => '12345',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_families', [
            'kk_number' => '1234567890123456',
        ]);
    }

    public function test_sid_family_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $family = SidFamily::factory()->create();

        $response = $this->put('/dashboard/sid/population/families/'.$family->id, [
            'kk_number' => '9876543210987654',
            'head_of_family_nik' => '9876543210987654',
            'address' => 'Jl. Contoh Baru No. 2',
            'rt' => '002',
            'rw' => '002',
            'village' => 'Desa Contoh Baru',
            'district' => 'Kecamatan Contoh Baru',
            'city' => 'Kota Contoh Baru',
            'province' => 'Provinsi Contoh Baru',
            'postal_code' => '54321',
        ]);

        $family->refresh();

        $this->assertEquals('9876543210987654', $family->kk_number);
        $this->assertEquals('Jl. Contoh Baru No. 2', $family->address);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_family_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $family = SidFamily::factory()->create();

        $response = $this->delete('/dashboard/sid/population/families/'.$family->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_families', [
            'id' => $family->id,
        ]);
    }
}
