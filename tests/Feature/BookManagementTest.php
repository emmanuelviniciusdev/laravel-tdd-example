<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->createBook();

        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/1');
    }
    
    /** @test */
    public function a_title_is_required()
    {
        $response = $this->createBook('');

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_required()
    {
        $response = $this->createBook('a', '');

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        /**
         * Create a book before updating
         */
        $this->createBook();

        $newBookTitle = 'O Segredo da Morta (eu quero ler esse livro)';

        $response = $this->patch('/api/books/1', [
            'title' => $newBookTitle
        ]);

        $this->assertEquals($newBookTitle, Book::first()->title);
        $response->assertRedirect('/books/1');
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        /**
         * Create a book before deleting
         */
        $this->createBook();

        $response = $this->delete('/api/books/1');

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    protected function createBook($title = 'O Segredo da Morta', $author = 'António de Assis')
    {
        return $this->post('/api/books', [
            'title' => $title,
            'author' => $author
        ]);
    }
}
