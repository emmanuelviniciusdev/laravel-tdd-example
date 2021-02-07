<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'birthday' => 'required',
        ]);

        $newAuthor = Author::create($data);

        return redirect("/authors/{$newAuthor->id}");
    }
}
