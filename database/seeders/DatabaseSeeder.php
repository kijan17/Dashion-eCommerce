<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // HAPUS KODE BAWAAN LARAVEL YANG SEPERTI INI:
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // --- GANTI DENGAN KODE KITA ---

        // 1. Buat Akun Owner
        User::create([
            'username' => 'owner1',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
        ]);

        // 2. Buat Akun Pembeli (untuk tes)
        User::create([
            'username' => 'pembeli1',
            'password' => Hash::make('password123'),
            'role' => 'pembeli',
        ]);

        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
