<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rentgame.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pembeli Test',
            'email' => 'pembeli@rentgame.com',
            'password' => bcrypt('password'),
            'role' => 'pembeli',
        ]);
    }
}
