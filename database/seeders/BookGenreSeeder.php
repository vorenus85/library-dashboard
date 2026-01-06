<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BookGenreSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/book_genres.json');
        $data = json_decode(File::get($path), true);

        foreach ($data as $item) {
            $book = Book::where('isbn', $item['book_isbn'])->first();

            if (! $book) {
                continue; // vagy throw Exception
            }

            $genreIds = Genre::whereIn('name', $item['genres'])
                ->pluck('id')
                ->toArray();

            $book->genres()->sync($genreIds);
        }

        $this->command->info('Book Genre pivot data seeded successfully!');
    }
}
