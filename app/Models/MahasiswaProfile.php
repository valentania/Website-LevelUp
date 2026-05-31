<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // Academic
        'university',
        'major',
        'student_id',
        'semester',
        // Personal
        'bio',
        'phone',
        'city',
        // Skills & Interests
        'skills',
        'interest_fields',
        // Experience
        'organization_experience',
        'project_experience',
        'work_experience',
        'certificates',
        // Links
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'instagram_url',
        'cv_path',
        // Stats
        'total_points',
        'missions_completed',
    ];

    protected function casts(): array
    {
        return [
            'semester'        => 'integer',
            'total_points'    => 'integer',
            'missions_completed' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSkillsArrayAttribute(): array
    {
        if (!$this->skills) return [];
        return array_map('trim', explode(',', $this->skills));
    }

    public function getInterestFieldsArrayAttribute(): array
    {
        if (!$this->interest_fields) return [];
        return array_map('trim', explode(',', $this->interest_fields));
    }

    public function getProfileCompletenessAttribute(): int
    {
        $fields = ['bio','phone','university','major','skills','linkedin_url','github_url','city'];
        $filled = collect($fields)->filter(fn($f) => !empty($this->$f))->count();
        return (int) round(($filled / count($fields)) * 100);
    }
}
