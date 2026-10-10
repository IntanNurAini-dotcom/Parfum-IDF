<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create/Update Admin User
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Parfum IDF',
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Gedung IDF Luxury Suite 101, Jakarta Selatan',
                'password' => 'admin12345',
            ]
        );

        // 2. Create/Update Demo Customer User
        User::updateOrCreate(
            ['email' => 'pembeli@gmail.com'],
            [
                'name' => 'Siti Nurhaliza',
                'role' => 'customer',
                'phone' => '089876543210',
                'address' => 'Jl. Mawar Merah No. 12, Kebayoran Baru, Jakarta Selatan',
                'password' => 'pembeli12345',
            ]
        );

        // 3. Call Category & Product Seeders
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
