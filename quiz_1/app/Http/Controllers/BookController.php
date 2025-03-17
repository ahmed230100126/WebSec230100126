<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer|digits:4',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function save(Request $request, Book $book = null)
    {
        $book = $book ?? new Book();
        $book->fill($request->all());
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book saved successfully');
    }
}
