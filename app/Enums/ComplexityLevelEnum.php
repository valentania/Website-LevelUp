<?php

namespace App\Enums;

enum ComplexityLevelEnum: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';

    public function label(): string
    {
        return match ($this) {
            self::EASY => 'Mudah',
            self::MEDIUM => 'Menengah',
            self::HARD => 'Sulit',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EASY => 'green',
            self::MEDIUM => 'yellow',
            self::HARD => 'red',
        };
    }

    public function points(): int
    {
        return match ($this) {
            self::EASY   => 50,
            self::MEDIUM => 75,
            self::HARD   => 100,
        };
    }
}
