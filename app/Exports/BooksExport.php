<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BooksExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Book::with('author:id,name')
            ->select('id','title','description','pages','is_read','is_wishlist','author_id')
            ->get();
    }

    // Fejlécek
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Description',
            'Pages',
            'Is Read',
            'Is Wishlist',
            'Author',
        ];
    }

    // Minden sor formázása
    public function map($book): array
    {
        return [
            $book->id,
            $book->title,
            $book->description,
            $book->pages,
            $book->is_read ? 'Yes' : 'No',
            $book->is_wishlist ? 'Yes' : 'No',
            $book->author?->name ?? '',
        ];
    }
}
