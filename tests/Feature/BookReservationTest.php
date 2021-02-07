<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/api/books', [
            'title' => 'O Segredo da Morta',
            'author' => 'António de Assis'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }
    
    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/api/books', [
            'title' => '',
            'author' => 'António de Assis'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_required()
    {
        $response = $this->post('/api/books', [
            'title' => 'O Segredo da Morta',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        /**
         * Create a book before updating
         */
        $this->post('/api/books', [
            'title' => 'O Segredo da Morta',
            'author' => 'António de Assis'
        ]);

        $newBookTitle = 'O Segredo da Morta (eu quero ler esse livro)';

        $response = $this->patch('/api/books/1', [
            'title' => $newBookTitle
        ]);

        $this->assertEquals($newBookTitle, Book::first()->title);
    }
}
