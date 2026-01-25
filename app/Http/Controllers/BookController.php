<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Book::with(['author:id,name'])->with(['genres:id'])->select('id', 'title', 'image', 'description', 'pages', 'is_read', 'is_wishlist', 'author_id')->orderBy('title', 'asc')->get();
            return response()->json(BookResource::collection($books), 200);
        } catch (\Throwable $th) {
            Log::error('Book list failed', [
                'user_id' => auth()->id(),
                'payload' => request()->all(),
            ]);

            throw $th;
        }
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
            'wishlisted_at' => isset($validated['is_wishlist']) ? now() : null,
        ]);

        // save to pivot
            if (!empty($validated['genres'])) {
            $book->genres()->sync($validated['genres']);
        }

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['author:id,name'])->load(['genres:id,name']);
        $book['image_url'] = $book->image ? Storage::url('/uploads/'.$book->image) : "";
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

        $book->is_read = !$book->is_read;
        $book->save();
        return response()->json(["status" => "ok"], 200);
    }

    public function toggleWishlist(Book $book) {
        $book->is_wishlist = !$book->is_wishlist;
        $book->wishlisted_at = $book->is_wishlist ? now() : null;
        $book->save();
        return response()->json(["status" => "ok"], 200);
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
        $validated["wishlisted_at"] = $book->wishlisted_at === null && $validated['is_wishlist'] ? now() : null;

        $book->update($validated);
        // save to pivot
            if (!empty($validated['genres'])) {
            $book->genres()->sync($validated['genres']);
        }
        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->image && Storage::exists('/uploads/'.$book->image)) {
            Storage::delete('/uploads/'.$book->image);
            $book->delete();
            return response()->json(['status' => 'ok'], 200);
        }

        return abort();
    }
}
