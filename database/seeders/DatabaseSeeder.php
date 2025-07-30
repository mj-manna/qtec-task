<?php

namespace Database\Seeders;

use App\Models\Service;
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
            'email_verified_at' => now(),
        ]);

        // Create sample customers
        User::create([
            'id' => 2,
            'name' => 'Manna',
            'email' => 'manna@qtech.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);


        $service1 = Service::create([
            'name' => 'Web Development',
            'description' => 'Professional web development services including frontend, backend, and full-stack solutions.',
            'price' => 1500.00,
            'status' => 'active',
        ]);

        $service2 = Service::create([
            'name' => 'Mobile App Development',
            'description' => 'Native and cross-platform mobile app development for iOS and Android.',
            'price' => 2500.00,
            'status' => 'active',
        ]);

        $service3 = Service::create([
            'name' => 'Digital Marketing',
            'description' => 'Complete digital marketing solutions including SEO, social media, and PPC campaigns.',
            'price' => 800.00,
            'status' => 'active',
        ]);

        $service4 = Service::create([
            'name' => 'UI/UX Design',
            'description' => 'Modern and user-friendly UI/UX design services for web and mobile applications.',
            'price' => 1200.00,
            'status' => 'active',
        ]);
    }
}