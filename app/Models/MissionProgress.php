<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionProgress extends Model
{
    use HasFactory;
    
    protected $table = 'mission_progresses';

    protected $fillable = [
        'mission_id',
        'user_id',
        'application_id',
        'status',
        'progress_note',
        'submission_link',
        'attachment_path',
        'revision_note',
        'revision_count',
        'submitted_at',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at'  => 'datetime',
            'status'       => \App\Enums\ProgressStatusEnum::class,
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

    public function messages()
    {
        return $this->hasMany(ProgressMessage::class, 'mission_progress_id')->orderBy('created_at', 'asc');
    }
}
