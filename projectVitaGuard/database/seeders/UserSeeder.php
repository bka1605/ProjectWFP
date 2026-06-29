<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@vitaguard.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Dr. Alvin Abel ',
                'email' => 'dokter@vitaguard.com',
                'role' => 'dokter',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Brian Kristanto',
                'email' => 'member@vitaguard.com',
                'role' => 'member',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                array_merge($user, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}