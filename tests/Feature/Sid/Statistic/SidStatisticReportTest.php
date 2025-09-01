<?php

namespace Tests\Feature\Sid\Statistic;

use App\Models\Sid\SidResident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidStatisticReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_statistic_report_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        // Create some dummy residents for statistics
        SidResident::factory()->count(5)->create(['date_of_birth' => now()->subYears(5)->format('Y-m-d')]);
        SidResident::factory()->count(3)->create(['date_of_birth' => now()->subYears(15)->format('Y-m-d')]);

        $response = $this->get('/dashboard/sid/statistics/reports');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Sid/Statistic/Report/Index')
            ->has('ageStatistics')
        );
    }
}
