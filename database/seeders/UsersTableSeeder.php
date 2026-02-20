<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin user',
            // @phpstan-ignore larastan.noEnvCallsOutsideOfConfig
            'email' => env('ADMIN_USER_EMAIL'),
            // @phpstan-ignore larastan.noEnvCallsOutsideOfConfig
            'password' => Hash::make(env('ADMIN_USER_PWD')),
        ]);

        $this->command->info('Users data seeded successfully!');
    }
}
