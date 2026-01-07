<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->boolean('minimal')){
            $genre = Genre::select('id', 'name')->orderBy('name', 'asc')->get();

            return response()->json($genre);
        }

        $genre = Genre::select('id', 'name', 'description')->withCount('books')->orderBy('name', 'asc')->get();

        return response()->json($genre);

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
            'name' => 'required|unique:genres,name|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $genre = Genre::create([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        return response()->json($genre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return response()->json($genre);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $genre->update($validated);
            return response()->json($genre, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during update' ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        try {
            $genre->delete();
            return response()->json([ 'status' => 'ok' ], 200);
        } catch (\Throwable $th) {
            // todo log error
            return response()->json([ 'status' => 'ok', 'message' => 'Error during delete' ], 500);
        }
    }
}
