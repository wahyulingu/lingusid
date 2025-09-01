<?php

namespace Tests\Feature\Sid\Assistance;

use App\Models\Sid\SidAssistanceProgram;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidAssistanceProgramTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_assistance_program_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/assistances/programs');

        $response->assertOk();
    }

    public function test_sid_assistance_program_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/assistances/programs', [
            'name' => 'Program Sembako',
            'description' => 'Program bantuan sembako untuk warga miskin',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'budget' => 10000000.00,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_assistance_programs', [
            'name' => 'Program Sembako',
        ]);
    }

    public function test_sid_assistance_program_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $program = SidAssistanceProgram::factory()->create();

        $response = $this->put('/dashboard/sid/assistances/programs/'.$program->id, [
            'name' => 'Program Pendidikan',
            'description' => 'Program bantuan pendidikan untuk siswa berprestasi',
            'start_date' => '2024-07-01',
            'end_date' => '2025-06-30',
            'budget' => 5000000.00,
        ]);

        $program->refresh();

        $this->assertEquals('Program Pendidikan', $program->name);
        $this->assertEquals(5000000.00, $program->budget);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_assistance_program_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $program = SidAssistanceProgram::factory()->create();

        $response = $this->delete('/dashboard/sid/assistances/programs/'.$program->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_assistance_programs', [
            'id' => $program->id,
        ]);
    }
}
