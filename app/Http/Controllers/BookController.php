<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['author:id,name'])->select('id', 'title', 'description', 'pages', 'is_read', 'is_wishlist', 'author_id')->orderBy('title', 'asc')->get();
        return response()->json($books, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|unique:books,title|max:255',
            'publised_year' => 'nullable|numeric',
            'pages' => 'nullable|numeric',
            'isbn' => 'nullable|string',
            'image' => 'nullable|string',
            'description' => 'nullable|string|max:500',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'publised_year' => $request['publised_year'],
            'pages' => $request['pages'],
            'isbn' => $request['isbn'],
            'image' => $request['image'],
            'description' => $request['description'],
        ]);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    public function toggleRead(Book $book) {

        try {
            $book->is_read = !$book->is_read;
            $book->save();
            return response()->json(["status" => "ok"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during toggleRead' ], 500);
        }
    }

    public function toggleWishlist(Book $book) {
        try {
            $book->is_wishlist = !$book->is_wishlist;
            $book->save();
            return response()->json(["status" => "ok"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during toggleWishlist' ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
        try {
            $book->delete();
            return response()->json(['status' => "ok"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            // todo log error
            return response()->json([ 'status' => 'error', 'message' => 'Error during delete' ], 500);
        }
    }
}
