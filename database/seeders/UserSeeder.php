<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@sollupos.com',
                'role' => 'superadmin',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ],
            [
                'name' => 'Admin Utama',
                'email' => 'admin@sollupos.com',
                'role' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ],
            [
                'name' => 'Content Creator',
                'email' => 'creator@sollupos.com',
                'role' => 'creator',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
