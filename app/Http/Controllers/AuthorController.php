<?php

namespace App\Http\Controllers;

use App\Models\Author;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount(['books'])->orderBy('name', 'asc')->get();

        return response()->json($authors)->setStatusCode(200);
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
            'name' => 'required|unique:authors,name|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $author = Author::create([
            'name' => $validated['name'],
            'description' => $request['description']
        ]);

        return response()->json($author, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return response()->json($author);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:authors,name,' . $author->id,
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $author->update($validated);
            return response()->json($author, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during update' ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        try {
            $author->delete();
            return response()->json([ 'status' => 'ok' ], 200);
        } catch (\Throwable $th) {
            // todo log error
            return response()->json([ 'status' => 'error', 'message' => 'Error during delete' ], 500);
        }
    }
}
