<?php

namespace Tests\Feature\Sid\Statistic;

use App\Models\Sid\SidResident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidPopulationStatisticTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_population_statistic_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        // Create some dummy residents for statistics
        SidResident::factory()->count(5)->create(['gender' => 'Laki-laki']);
        SidResident::factory()->count(3)->create(['gender' => 'Perempuan']);

        $response = $this->get('/dashboard/sid/statistics/population');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Sid/Statistic/Population/Index')
            ->has('genderStatistics', fn ($prop) => $prop
                ->has('Laki-laki')
                ->has('Perempuan')
            )
        );
    }
}
