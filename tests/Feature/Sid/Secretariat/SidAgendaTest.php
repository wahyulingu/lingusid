<?php

namespace Tests\Feature\Sid\Secretariat;

use App\Models\Sid\SidAgenda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidAgendaTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_agenda_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/secretariat/agendas');

        $response->assertOk();
    }

    public function test_sid_agenda_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/secretariat/agendas', [
            'title' => 'Rapat Mingguan',
            'description' => 'Pembahasan progres proyek',
            'date' => '2025-09-01',
            'time' => '09:00',
            'location' => 'Ruang Rapat',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_agendas', [
            'title' => 'Rapat Mingguan',
        ]);
    }

    public function test_sid_agenda_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $agenda = SidAgenda::factory()->create();

        $response = $this->put('/dashboard/sid/secretariat/agendas/'.$agenda->id, [
            'title' => 'Rapat Bulanan',
            'description' => 'Evaluasi kinerja',
            'date' => '2025-10-01',
            'time' => '10:00',
            'location' => 'Aula',
        ]);

        $agenda->refresh();

        $this->assertEquals('Rapat Bulanan', $agenda->title);
        $this->assertEquals('Aula', $agenda->location);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_agenda_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $agenda = SidAgenda::factory()->create();

        $response = $this->delete('/dashboard/sid/secretariat/agendas/'.$agenda->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_agendas', [
            'id' => $agenda->id,
        ]);
    }
}
