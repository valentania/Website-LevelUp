<?php

namespace App\Enums;

enum MissionStatusEnum: string
{
    case DRAFT = 'draft';
    case PENDING_REVIEW = 'pending_review';
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case UNDER_REVIEW = 'under_review';
    case REVISION = 'revision';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING_REVIEW => 'Menunggu Review',
            self::OPEN => 'Terbuka',
            self::IN_PROGRESS => 'Sedang Dikerjakan',
            self::UNDER_REVIEW => 'Menunggu Approval',
            self::REVISION => 'Revisi',
            self::COMPLETED => 'Selesai',
            self::CANCELLED => 'Dibatalkan',
            self::REJECTED => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PENDING_REVIEW => 'yellow',
            self::OPEN => 'blue',
            self::IN_PROGRESS => 'indigo',
            self::UNDER_REVIEW => 'orange',
            self::REVISION => 'amber',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
            self::REJECTED => 'red',
        };
    }
}
