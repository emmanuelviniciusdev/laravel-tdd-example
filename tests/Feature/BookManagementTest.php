<?php

namespace Tests\Feature;

use App\Models\Author;
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

        $response->assertSessionHasErrors('authorName');
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

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->createBook();

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    protected function createBook($title = 'O Segredo da Morta', $authorName = 'António de Assis')
    {
        return $this->post('/api/books', [
            'title' => $title,
            'authorName' => $authorName
        ]);
    }
}
