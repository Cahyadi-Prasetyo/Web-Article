<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ]
        );

        // Sample Regular Users (hanya bisa melihat artikel)
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@example.com',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Charlie Wilson',
                'email' => 'charlie@example.com',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']], 
                $userData
            );
        }
    }
}
