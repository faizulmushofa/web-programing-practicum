<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeders extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'owner',
                'email'    => 'owner@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'user',
                'email'    => 'user@gmail.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
