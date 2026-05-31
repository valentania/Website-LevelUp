<?php

namespace App\Models;

use App\Enums\ComplexityLevelEnum;
use App\Enums\MissionCategoryEnum;
use App\Enums\MissionStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'complexity',
        'status',
        'max_applicants',
        'points_reward',
        'deadline',
        'requirements',
        'deliverables',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'category' => MissionCategoryEnum::class,
            'complexity' => ComplexityLevelEnum::class,
            'status' => MissionStatusEnum::class,
            'deadline' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    // ── Relationships ──

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(MissionApplication::class);
    }

    public function progress(): HasOne
    {
        return $this->hasOne(MissionProgress::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(MissionReview::class);
    }

    public function portfolio(): HasOne
    {
        return $this->hasOne(Portfolio::class);
    }

    // ── Scopes ──

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', MissionStatusEnum::OPEN);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeByComplexity(Builder $query, string $complexity): Builder
    {
        return $query->where('complexity', $complexity);
    }

    public function scopeForUmkm(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', MissionStatusEnum::PENDING_REVIEW);
    }
}
