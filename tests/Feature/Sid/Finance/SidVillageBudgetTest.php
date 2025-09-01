<?php

namespace Tests\Feature\Sid\Finance;

use App\Models\Sid\SidVillageBudget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidVillageBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_village_budget_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/finance/budgets');

        $response->assertOk();
    }

    public function test_sid_village_budget_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/finance/budgets', [
            'year' => 2024,
            'budget_type' => 'pendapatan',
            'description' => 'Dana Desa',
            'amount' => 100000000.00,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_village_budgets', [
            'year' => 2024,
            'budget_type' => 'pendapatan',
        ]);
    }

    public function test_sid_village_budget_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $budget = SidVillageBudget::factory()->create();

        $response = $this->put('/dashboard/sid/finance/budgets/'.$budget->id, [
            'year' => 2025,
            'budget_type' => 'belanja',
            'description' => 'Pembangunan Jalan',
            'amount' => 50000000.00,
        ]);

        $budget->refresh();

        $this->assertEquals(2025, $budget->year);
        $this->assertEquals('belanja', $budget->budget_type);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_village_budget_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $budget = SidVillageBudget::factory()->create();

        $response = $this->delete('/dashboard/sid/finance/budgets/'.$budget->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_village_budgets', [
            'id' => $budget->id,
        ]);
    }
}
