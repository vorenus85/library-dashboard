<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;

class BookExportController extends Controller
{
    public function export(Request $request)
    {
        try {
            $format = $request->query('format', 'csv'); // alapértelmezett csv

            // Lekérjük az adatokat eager load author
            $books = Book::with('author:id,name')
                ->select('id','title','description','pages','is_read','is_wishlist','author_id')
                ->get();

            if ($format === 'excel') {
                // Excel export a maatwebsite/excel segítségével
                return Excel::download(new BooksExport(), 'books.xlsx');
            }

            // CSV export
            $filename = 'books.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
            ];

            $callback = function () use ($books) {
                $file = fopen('php://output', 'w');

                // Fejlécek
                fputcsv($file, ['ID','Title','Description','Pages','Is Read','Is Wishlist','Author']);

                foreach ($books as $book) {
                    fputcsv($file, [
                        $book->id,
                        $book->title,
                        $book->description,
                        $book->pages,
                        $book->is_read ? 'Yes' : 'No',
                        $book->is_wishlist ? 'Yes' : 'No',
                        $book->author->name ?? '',
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error during book export',
            ], 500);
        }
    }
}
