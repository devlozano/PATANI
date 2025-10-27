<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@patanitrinidad.com',
            'password' => Hash::make('password123'),
        ]);

        // You can create more users here
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@patanitrinidad.com',
            'password' => Hash::make('admin123'),
        ]);

        // Or use factory to create multiple users
        // User::factory(10)->create();
    }
}