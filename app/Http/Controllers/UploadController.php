<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
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
        } catch (\Throwable $th) {

            Log::error('Book delete upload failed', [
                'user_id' => auth()->id(),
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return response()->json([ 'status' => 'error', 'message' => 'Error during upload book image' ], 500);
        }
    }

    public function delete(Book $book){
        try {
            $image = $book->image;
            $book->update(["image" => ""]);

            File::delete("storage/uploads/{$image}");

            return response()->json(["status" => 'ok']);

        } catch (\Throwable $th) {

            Log::error('Book delete image failed', [
                'user_id' => auth()->id(),
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return response()->json([ 'status' => 'error', 'message' => 'Error during delete book image' ], 500);
        }
    }
}
