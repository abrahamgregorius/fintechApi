<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        User::insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ],
            [
                'username' => 'student',
                'password' => Hash::make('student123'),
                'role' => 'student'
            ],
            [
                'username' => 'bank',
                'password' => Hash::make('bank123'),
                'role' => 'bank'
            ],
            [
                'username' => 'shop',
                'password' => Hash::make('shop123'),
                'role' => 'shop'
            ],
            [
                'username' => 'userone',
                'password' => Hash::make('userone123'),
                'role' => 'student'
            ],
        ]);
    }
}
