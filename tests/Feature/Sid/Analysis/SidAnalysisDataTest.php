<?php

namespace Tests\Feature\Sid\Analysis;

use App\Models\Sid\SidAnalysisData;
use App\Models\Sid\SidAnalysisMaster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidAnalysisDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_analysis_data_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/analysis/data');

        $response->assertOk();
    }

    public function test_sid_analysis_data_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $master = SidAnalysisMaster::factory()->create();

        $response = $this->post('/dashboard/sid/analysis/data', [
            'analysis_master_id' => $master->id,
            'value' => 'Some Value',
            'notes' => 'Some notes for the data',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_analysis_data', [
            'analysis_master_id' => $master->id,
            'value' => 'Some Value',
        ]);
    }

    public function test_sid_analysis_data_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $data = SidAnalysisData::factory()->create();
        $newMaster = SidAnalysisMaster::factory()->create();

        $response = $this->put('/dashboard/sid/analysis/data/'.$data->id, [
            'analysis_master_id' => $newMaster->id,
            'value' => 'New Value',
            'notes' => 'New notes for the data',
        ]);

        $data->refresh();

        $this->assertEquals($newMaster->id, $data->analysis_master_id);
        $this->assertEquals('New Value', $data->value);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_analysis_data_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $data = SidAnalysisData::factory()->create();

        $response = $this->delete('/dashboard/sid/analysis/data/'.$data->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_analysis_data', [
            'id' => $data->id,
        ]);
    }
}
