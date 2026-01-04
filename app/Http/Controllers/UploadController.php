<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
