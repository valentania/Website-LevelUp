<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MissionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_id',
        'user_id',
        'cover_letter',
        'relevant_experience',
        'status',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ApplicationStatusEnum::class,
            'responded_at' => 'datetime',
        ];
    }

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function progress(): HasOne
    {
        return $this->hasOne(MissionProgress::class, 'application_id');
    }
}
