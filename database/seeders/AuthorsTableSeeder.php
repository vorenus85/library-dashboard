<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Author;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/authors.json'));
        $authors = json_decode($json, true);

        // Adatok feltöltése
        foreach ($authors as $author) {
            Author::create([
                'name' => $author['name'],
                'description' => $author['description'],
            ]);
        }

        $this->command->info('Authors data seeded successfully!');
    }
}
