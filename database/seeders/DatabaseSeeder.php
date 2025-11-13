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
        // Buat admin default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@bpkad.local',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Buat beberapa user contoh
        User::create([
            'name' => 'Karyawan 1',
            'email' => 'karyawan1@bpkad.local',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Karyawan 2',
            'email' => 'karyawan2@bpkad.local',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Karyawan 3',
            'email' => 'karyawan3@bpkad.local',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);
    }
}
