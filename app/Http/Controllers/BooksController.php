<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BooksController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        $newBook = Book::create($data);

        return response($newBook);
    }

    public function update(int $bookId)
    {
        $data = request()->all();

        $updatedBookId = Book::find($bookId)->update($data);

        return $updatedBookId;
    }
}
