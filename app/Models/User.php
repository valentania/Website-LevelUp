<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_suspended',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
            'is_suspended' => 'boolean',
        ];
    }

    // ── Relationships ──

    public function mahasiswaProfile(): HasOne
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    public function umkmProfile(): HasOne
    {
        return $this->hasOne(UmkmProfile::class);
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(MissionApplication::class);
    }

    // Alias for clarity in views
    public function missionApplications(): HasMany
    {
        return $this->hasMany(MissionApplication::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(MissionProgress::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function pointHistories(): HasMany
    {
        return $this->hasMany(PointHistory::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'mahasiswa_skill')
            ->withPivot('proficiency')
            ->withTimestamps();
    }

    // ── Role Helpers ──

    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN;
    }

    public function isMahasiswa(): bool
    {
        return $this->role === RoleEnum::MAHASISWA;
    }

    public function isUmkm(): bool
    {
        return $this->role === RoleEnum::UMKM;
    }

    // ── Computed Helpers ──

    public function getTotalPoints(): int
    {
        return $this->mahasiswaProfile?->total_points ?? 0;
    }

    public function getBadgeCategory(): array
    {
        $points = $this->getTotalPoints();
        if ($points >= 10000) {
            return ['name' => 'Hero', 'icon' => '🦸', 'color' => '#8B5CF6', 'bg' => 'rgba(139,92,246,0.12)', 'border' => 'rgba(139,92,246,0.3)'];
        } elseif ($points >= 5000) {
            return ['name' => 'Gold', 'icon' => '🥇', 'color' => '#EAB308', 'bg' => 'rgba(234,179,8,0.12)', 'border' => 'rgba(234,179,8,0.3)'];
        } elseif ($points >= 1000) {
            return ['name' => 'Silver', 'icon' => '🥈', 'color' => '#94A3B8', 'bg' => 'rgba(148,163,184,0.12)', 'border' => 'rgba(148,163,184,0.3)'];
        } else {
            return ['name' => 'Bronze', 'icon' => '🥉', 'color' => '#D97706', 'bg' => 'rgba(217,119,6,0.12)', 'border' => 'rgba(217,119,6,0.3)'];
        }
    }

    public function getAverageRating(): float
    {
        return round(
            MissionReview::where('reviewee_id', $this->id)->avg('rating') ?? 0,
            1
        );
    }
}
