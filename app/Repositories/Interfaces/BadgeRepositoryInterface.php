<?php

namespace App\Repositories\Interfaces;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Collection;

interface BadgeRepositoryInterface
{
    public function getAll(): Collection;
    public function findBySlug(string $slug): ?Badge;
    public function getUserBadges(int $userId): Collection;
    public function awardBadge(int $userId, int $badgeId): void;
    public function hasBadge(int $userId, int $badgeId): bool;
}
