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
            Book::create([
                "title" => $book['title'],
                "authorId" => $book['authorId'],
                "publised_year" => $book['publised_year'],
                "isbn" => $book['isbn'],
                "image" => $book['image'],
                "pages" => $book['pages'],
                "description" => $book['description'],
            ]);
        }

        $this->command->info('Books data seeded successfully!');
    }
}
