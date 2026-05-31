<?php

namespace App\Enums;

enum ProgressStatusEnum: string
{
    case IN_PROGRESS = 'in_progress';
    case SUBMITTED = 'submitted';
    case REVISION_REQUESTED = 'revision_requested';
    case FINAL_SUBMITTED = 'final_submitted';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'Sedang Dikerjakan',
            self::SUBMITTED => 'Sudah Disubmit',
            self::REVISION_REQUESTED => 'Perlu Revisi',
            self::FINAL_SUBMITTED => 'Final Disubmit',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'blue',
            self::SUBMITTED => 'indigo',
            self::REVISION_REQUESTED => 'amber',
            self::FINAL_SUBMITTED => 'purple',
            self::APPROVED => 'green',
            self::REJECTED => 'red',
        };
    }
}
