<?php

namespace App\Repositories\Eloquent;

use App\Models\Badge;
use App\Models\User;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BadgeRepository implements BadgeRepositoryInterface
{
    public function __construct(private Badge $model) {}

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function findBySlug(string $slug): ?Badge
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function getUserBadges(int $userId): Collection
    {
        return User::find($userId)?->badges ?? new Collection();
    }

    public function awardBadge(int $userId, int $badgeId): void
    {
        $user = User::find($userId);
        if ($user && !$this->hasBadge($userId, $badgeId)) {
            $user->badges()->attach($badgeId, ['earned_at' => now()]);
        }
    }

    public function hasBadge(int $userId, int $badgeId): bool
    {
        return User::find($userId)?->badges()->where('badge_id', $badgeId)->exists() ?? false;
    }
}
