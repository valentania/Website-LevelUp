<?php

namespace App\Enums;

enum MissionCategoryEnum: string
{
    case DESAIN_GRAFIS   = 'desain-grafis';
    case PEMASARAN       = 'pemasaran';
    case PENGEMBANGAN_WEB = 'pengembangan-web';
    case KONTEN_MEDIA    = 'konten-media';
    case DATA_LAPORAN    = 'data-laporan';
    case ADMINISTRASI    = 'administrasi';
    case EDUKASI         = 'edukasi';
    case LAINNYA         = 'lainnya';

    public static function generalCases(): array
    {
        return [
            self::DESAIN_GRAFIS,    // Desain & Kreatif
            self::PEMASARAN,        // Pemasaran & Sosial Media
            self::PENGEMBANGAN_WEB, // Teknologi & IT
            self::ADMINISTRASI,     // Administrasi & Operasional
            self::EDUKASI,          // Edukasi & Pelatihan
            self::LAINNYA,          // Lainnya
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::DESAIN_GRAFIS    => 'Desain & Kreatif',
            self::PEMASARAN        => 'Pemasaran & Sosial Media',
            self::PENGEMBANGAN_WEB => 'Teknologi & IT',
            self::KONTEN_MEDIA     => 'Pemasaran & Sosial Media',
            self::DATA_LAPORAN     => 'Administrasi & Operasional',
            self::ADMINISTRASI     => 'Administrasi & Operasional',
            self::EDUKASI          => 'Edukasi & Pelatihan',
            self::LAINNYA          => 'Lainnya',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::DESAIN_GRAFIS    => '🎨',
            self::PEMASARAN        => '📣',
            self::PENGEMBANGAN_WEB => '🌐',
            self::KONTEN_MEDIA     => '📣',
            self::DATA_LAPORAN     => '📋',
            self::ADMINISTRASI     => '📋',
            self::EDUKASI          => '📚',
            self::LAINNYA          => '💡',
        };
    }

    public function toGeneral(): self
    {
        return match ($this) {
            self::KONTEN_MEDIA => self::PEMASARAN,
            self::DATA_LAPORAN => self::ADMINISTRASI,
            default            => $this,
        };
    }
}
