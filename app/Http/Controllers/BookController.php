<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['author:id,name'])->with(['genres:id'])->select('id', 'title', 'image', 'description', 'pages', 'is_read', 'is_wishlist', 'author_id')->orderBy('title', 'asc')->get();
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
        try {
            $validated = $request->validate([
                'title' => 'required|unique:books,title|max:255',
                'author' => 'required|array',
                'genres' => 'required|array',
                'genres.*' => 'exists:genres,id',
                'author.id' => 'required|numeric',
                'published_year' => 'nullable|numeric',
                'pages' => 'nullable|numeric',
                'isbn' => 'nullable|string',
                'description' => 'nullable|string|max:500',
                'is_read' => 'nullable|boolean',
                'is_wishlist' => 'nullable|boolean',
                'image' => 'nullable|string',
            ]);

            $book = Book::create([
                'title' => $validated['title'],
                "author_id" => $validated['author']["id"],
                'published_year' => $validated['published_year'] ?? null,
                'pages' => $validated['pages'] ?? null,
                'isbn' => $validated['isbn'] ?? "",
                'image' => $validated['image'] ?? "",
                'description' => $validated['description'] ?? "",
                'is_read' => $validated['is_read'] ?? false,
                'is_wishlist' => $validated['is_wishlist'] ?? false,
            ]);

            // save to pivot
             if (!empty($validated['genres'])) {
                $book->genres()->sync($validated['genres']);
            }

            return response()->json($book, 201);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during create' ], 500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['author:id,name'])->load(['genres:id,name']);
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

        $validated = $request->validate([
            'title' => 'required|max:255|unique:books,title,' . $book->id,
            'author' => 'required|array',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'author.id' => 'required|numeric',
            'published_year' => 'nullable|numeric',
            'pages' => 'nullable|numeric',
            'isbn' => 'nullable|string',
            'image' => 'nullable|string',
            'description' => 'nullable|string|max:500',
            'is_read' => 'nullable|boolean',
            'is_wishlist' => 'nullable|boolean',
        ]);

        $validated["author_id"] = $validated["author"]["id"];

        try {
            $book->update($validated);
            // save to pivot
             if (!empty($validated['genres'])) {
                $book->genres()->sync($validated['genres']);
            }
            return response()->json($book, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during book update' ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
        try {
            $image = $book->image;
            File::delete("storage/uploads/{$image}");

            $book->delete();
            return response()->json(['status' => "ok"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            // todo log error
            return response()->json([ 'status' => 'error', 'message' => 'Error during delete' ], 500);
        }
    }
}
