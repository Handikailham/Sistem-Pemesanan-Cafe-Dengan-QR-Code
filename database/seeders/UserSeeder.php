<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'), // Password = admin
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@example.com',
            'password' => Hash::make('kasir'), // Password = kasir
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Dapur',
            'email' => 'dapur@example.com',
            'password' => Hash::make('dapur'), // Password = dapur
            'role' => 'dapur',
        ]);
    }
}
