<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'id' => 1,
            'name' => 'Super admin',
            'email' => 'admin@qtech.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample customers
        User::create([
            'id' => 2,
            'name' => 'Manna',
            'email' => 'manna@qtech.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

       User::create([
            'id' => 3,
            'name' => 'Tamanna',
            'email' => 'tamanna@qtech.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}