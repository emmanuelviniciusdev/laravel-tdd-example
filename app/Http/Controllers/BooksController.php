<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;

class BooksController extends Controller
{
    public function store()
    {
        $data = $this->validatedRequestData();

        $author = Author::firstOrCreate([
            'name' => $data['authorName']
        ]);
        
        $data['author_id'] = $author->id;

        unset($data['authorName']);

        $newBook = Book::create($data);

        return redirect("/books/{$newBook->id}");
    }

    public function update(int $bookId)
    {
        $data = request()->all();

        $updatedBookId = Book::find($bookId)->update($data);

        return redirect("/books/{$updatedBookId}");
    }

    public function destroy(int $bookId)
    {
        Book::destroy($bookId);

        return redirect('/books');
    }

    protected function validatedRequestData()
    {
        return request()->validate([
            'title' => 'required',
            'authorName' => 'required',
        ]);
    }
}
