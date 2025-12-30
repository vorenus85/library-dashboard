<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            AuthorsTableSeeder::class,
            UsersTableSeeder::class,
            GenreTableSeeder::class,
        ]);

        $this->command->info('All data seeded successfully!');
    }
}
