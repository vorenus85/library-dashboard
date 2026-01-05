<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as LaraFile;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file = $request->file('file');

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('uploads', $filename, 'public');

        return response()->json([
            'path' => $path,
            'filename' => $filename,
            'url' => asset('storage/' . $path),
        ]);
    }

    public function delete(Book $book){
        try {
            $image = $book->image;
            $book->update(["image" => ""]);

            LaraFile::delete("storage/uploads/{$image}");

            return response()->json(["status" => 'ok']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([ 'status' => 'error', 'message' => 'Error during delete book image' ], 500);
        }
    }
}
