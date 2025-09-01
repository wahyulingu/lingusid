<?php

namespace Tests\Feature\Sid\Letter;

use App\Models\Sid\SidLetterArchive;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidLetterArchiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_letter_archive_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/letters/archives');

        $response->assertOk();
    }

    public function test_sid_letter_archive_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/letters/archives', [
            'letter_number' => '123/ABC/DEF/2025',
            'letter_date' => '2025-01-01',
            'subject' => 'Surat Undangan',
            'sender' => 'Kantor Desa',
            'recipient' => 'Warga Desa',
            'description' => 'Description for Surat Undangan',
            'file_path' => '/path/to/file.pdf',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_letter_archives', [
            'letter_number' => '123/ABC/DEF/2025',
        ]);
    }

    public function test_sid_letter_archive_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $archive = SidLetterArchive::factory()->create();

        $response = $this->put('/dashboard/sid/letters/archives/'.$archive->id, [
            'letter_number' => '456/XYZ/UVW/2025',
            'letter_date' => '2025-02-01',
            'subject' => 'Surat Pemberitahuan',
            'sender' => 'Pemerintah Desa',
            'recipient' => 'Seluruh Warga',
            'description' => 'Description for Surat Pemberitahuan',
            'file_path' => '/path/to/new_file.pdf',
        ]);

        $archive->refresh();

        $this->assertEquals('456/XYZ/UVW/2025', $archive->letter_number);
        $this->assertEquals('Surat Pemberitahuan', $archive->subject);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_letter_archive_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $archive = SidLetterArchive::factory()->create();

        $response = $this->delete('/dashboard/sid/letters/archives/'.$archive->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_letter_archives', [
            'id' => $archive->id,
        ]);
    }
}
