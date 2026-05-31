<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin LevelUp',
            'email' => 'admin@levelup.test',
            'password' => Hash::make('password'),
            'role' => RoleEnum::ADMIN,
            'email_verified_at' => now(),
        ]);
    }
}
