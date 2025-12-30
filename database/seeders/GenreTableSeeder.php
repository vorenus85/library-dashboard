<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/genres.json'));
        $genres = json_decode($json, true);

        // Adatok feltöltése
        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre['name'],
                'description' => $genre['description'],
            ]);
        }

        $this->command->info('Genres data seeded successfully!');
    }
}
