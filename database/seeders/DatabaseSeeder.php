<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        User::factory()->create([
            'nom' => 'Admin',
            'prenom' => 'Admin',
            'email' => 'admin@test.fr',
            'password' => bcrypt('admin1234'),
            'role_id' => 1,
        ]);
    }
}
