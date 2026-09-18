<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin (satu-satunya akun awal)
        User::create([
            'name' => 'Admin Adibah',
            'email' => 'admin@adibahshop.com',
            'password' => 'Adibah$hop2026!Kuat',
            'role' => 'admin',
        ]);
    }
}