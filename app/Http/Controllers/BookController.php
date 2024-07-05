<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('genre');

        // Handle search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhereHas('genre', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Handle pagination
        $books = $query->paginate($request->input('per_page', 10));

        return response()->json($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'published_year' => 'required|integer',
            'ISBN' => 'required|string|max:13|unique:books,ISBN',
            'copies_available' => 'required|integer',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'genre_id' => $request->genre_id,
            'published_year' => $request->published_year,
            'ISBN' => $request->ISBN,
            'copies_available' => $request->copies_available,
        ]);

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return response()->json($book->load('genre'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'genre_id' => 'sometimes|required|exists:genres,id',
            'published_year' => 'sometimes|required|integer',
            'ISBN' => 'sometimes|required|string|max:13|unique:books,ISBN,'.$book->id,
            'copies_available' => 'sometimes|required|integer',
        ]);

        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'book deleted successfully'], 201);
    }
}
