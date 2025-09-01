<?php

namespace Tests\Feature\Sid\Secretariat;

use App\Models\Sid\SidAdministrationBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidAdministrationBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_administration_book_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/secretariat/books');

        $response->assertOk();
    }

    public function test_sid_administration_book_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/secretariat/books', [
            'title' => 'Buku Induk Penduduk',
            'description' => 'Catatan data penduduk desa',
            'book_number' => 'BIP-001',
            'year' => 2024,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_administration_books', [
            'title' => 'Buku Induk Penduduk',
        ]);
    }

    public function test_sid_administration_book_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $book = SidAdministrationBook::factory()->create();

        $response = $this->put('/dashboard/sid/secretariat/books/'.$book->id, [
            'title' => 'Buku Kas Umum',
            'description' => 'Catatan transaksi keuangan desa',
            'book_number' => 'BKU-001',
            'year' => 2023,
        ]);

        $book->refresh();

        $this->assertEquals('Buku Kas Umum', $book->title);
        $this->assertEquals('BKU-001', $book->book_number);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_administration_book_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $book = SidAdministrationBook::factory()->create();

        $response = $this->delete('/dashboard/sid/secretariat/books/'.$book->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_administration_books', [
            'id' => $book->id,
        ]);
    }
}
