<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed akun default Admin dan Petugas.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Petugas Lapangan',
            'username' => 'petugas',
            'email' => 'petugas@example.com',
            'password' => Hash::make('password'),
            'role' => 'Petugas',
        ]);
    }
}
