<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\MahasiswaProfile;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo mahasiswa accounts
        $mahasiswaData = [
            ['name' => 'Andi Pratama', 'email' => 'andi@levelup.test'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@levelup.test'],
            ['name' => 'Budi Santoso', 'email' => 'budi@levelup.test'],
        ];

        foreach ($mahasiswaData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => RoleEnum::MAHASISWA,
                'email_verified_at' => now(),
            ]);

            MahasiswaProfile::create([
                'user_id' => $user->id,
                'university' => 'Universitas Indonesia',
                'major' => 'Teknik Informatika',
                'student_id' => 'MHS' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                'bio' => 'Mahasiswa yang tertarik dengan teknologi dan kontribusi sosial.',
            ]);
        }

        // Create demo UMKM accounts
        $umkmData = [
            ['name' => 'Warung Makan Bahagia', 'email' => 'warung@levelup.test', 'type' => 'Kuliner'],
            ['name' => 'Toko Batik Nusantara', 'email' => 'batik@levelup.test', 'type' => 'Fashion'],
        ];

        foreach ($umkmData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => RoleEnum::UMKM,
                'email_verified_at' => now(),
            ]);

            UmkmProfile::create([
                'user_id' => $user->id,
                'business_name' => $data['name'],
                'business_type' => $data['type'],
                'business_description' => 'UMKM lokal yang membutuhkan bantuan digital.',
                'city' => 'Jakarta',
            ]);
        }
    }
}
