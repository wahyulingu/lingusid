<?php

namespace Tests\Feature\Sid\Analysis;

use App\Models\Sid\SidAnalysisMaster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidAnalysisMasterTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_analysis_master_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/analysis/master');

        $response->assertOk();
    }

    public function test_sid_analysis_master_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/analysis/master', [
            'name' => 'Analisis Kemiskinan',
            'description' => 'Analisis data kemiskinan penduduk',
            'type' => 'data',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_analysis_masters', [
            'name' => 'Analisis Kemiskinan',
        ]);
    }

    public function test_sid_analysis_master_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $master = SidAnalysisMaster::factory()->create();

        $response = $this->put('/dashboard/sid/analysis/master/'.$master->id, [
            'name' => 'Analisis Pendidikan',
            'description' => 'Analisis data pendidikan penduduk',
            'type' => 'report',
        ]);

        $master->refresh();

        $this->assertEquals('Analisis Pendidikan', $master->name);
        $this->assertEquals('report', $master->type);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_analysis_master_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $master = SidAnalysisMaster::factory()->create();

        $response = $this->delete('/dashboard/sid/analysis/master/'.$master->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_analysis_masters', [
            'id' => $master->id,
        ]);
    }
}
