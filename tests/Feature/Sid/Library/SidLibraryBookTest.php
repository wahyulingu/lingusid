<?php

namespace Tests\Feature\Sid\Library;

use App\Models\Sid\SidLibraryBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidLibraryBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_library_book_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/library/books');

        $response->assertOk();
    }

    public function test_sid_library_book_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/library/books', [
            'title' => 'Buku Sejarah Desa',
            'author' => 'John Doe',
            'publisher' => 'Penerbit A',
            'publication_year' => 2020,
            'isbn' => '978-1234567890',
            'quantity' => 10,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_library_books', [
            'title' => 'Buku Sejarah Desa',
        ]);
    }

    public function test_sid_library_book_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $book = SidLibraryBook::factory()->create();

        $response = $this->put('/dashboard/sid/library/books/'.$book->id, [
            'title' => 'Buku Geografi Desa',
            'author' => 'Jane Doe',
            'publisher' => 'Penerbit B',
            'publication_year' => 2021,
            'isbn' => '978-0987654321',
            'quantity' => 15,
        ]);

        $book->refresh();

        $this->assertEquals('Buku Geografi Desa', $book->title);
        $this->assertEquals('978-0987654321', $book->isbn);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_library_book_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $book = SidLibraryBook::factory()->create();

        $response = $this->delete('/dashboard/sid/library/books/'.$book->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_library_books', [
            'id' => $book->id,
        ]);
    }
}
