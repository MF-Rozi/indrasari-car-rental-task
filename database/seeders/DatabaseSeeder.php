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
        // Default Administrator
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@indrasari.test',
            'phone_number' => '081234567890',
            'address' => 'Headquarters Office, Jakarta',
            'sim_number' => 'ADMIN-001',
            'role' => 'admin',
        ]);

        // Default Sample Customer
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'customer@indrasari.test',
            'phone_number' => '089876543210',
            'address' => 'Jl. Sudirman No. 12, Jakarta',
            'sim_number' => '123456789012',
            'role' => 'customer',
        ]);
    }
}
