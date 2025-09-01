<?php

namespace Tests\Feature\Sid\Letter;

use App\Models\Sid\SidLetterTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidLetterTemplateTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_letter_template_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/letters/templates');

        $response->assertOk();
    }

    public function test_sid_letter_template_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/letters/templates', [
            'name' => 'Surat Keterangan',
            'code' => 'SK',
            'content' => 'Content of Surat Keterangan',
            'description' => 'Description for Surat Keterangan',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_letter_templates', [
            'name' => 'Surat Keterangan',
            'code' => 'SK',
        ]);
    }

    public function test_sid_letter_template_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $template = SidLetterTemplate::factory()->create();

        $response = $this->put('/dashboard/sid/letters/templates/'.$template->id, [
            'name' => 'Surat Pengantar',
            'code' => 'SP',
            'content' => 'Content of Surat Pengantar',
            'description' => 'Description for Surat Pengantar',
        ]);

        $template->refresh();

        $this->assertEquals('Surat Pengantar', $template->name);
        $this->assertEquals('SP', $template->code);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_letter_template_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $template = SidLetterTemplate::factory()->create();

        $response = $this->delete('/dashboard/sid/letters/templates/'.$template->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_letter_templates', [
            'id' => $template->id,
        ]);
    }
}
