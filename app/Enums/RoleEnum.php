<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case MAHASISWA = 'mahasiswa';
    case UMKM = 'umkm';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::MAHASISWA => 'Mahasiswa',
            self::UMKM => 'UMKM / Masyarakat',
        };
    }
}
