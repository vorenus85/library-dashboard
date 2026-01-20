<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json = File::get(database_path('data/books.json'));
        $books = json_decode($json, true);

        foreach ($books as $book) {
            try {
                Book::create([
                "title" => $book['title'],
                "author_id" => $book['author_id'],
                "published_year" => $book['published_year'],
                "isbn" => $book['isbn'],
                "image" => $book['image'],
                "pages" => $book['pages'],
                "is_read" => $book['is_read'],
                "is_wishlist" => $book['is_wishlist'],
                "wishlisted_at" => $book['is_wishlist'] ? now() : null,
                "description" => $book['description'],
            ]);
            } catch (\Throwable $th) {
                throw $th;
            }

        }

        $this->command->info('Books data seeded successfully!');
    }
}
