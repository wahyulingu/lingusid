<?php

namespace Tests\Feature\Sid\Analysis;

use App\Models\Sid\SidAnalysisData;
use App\Models\Sid\SidAnalysisMaster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidAnalysisReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_analysis_report_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        // Create some dummy data for the report
        SidAnalysisMaster::factory()->create(['name' => 'Master 1', 'type' => 'report']);
        SidAnalysisData::factory()->count(5)->create();

        $response = $this->get('/dashboard/sid/analysis/reports');

        $response->assertOk();
    }
}
