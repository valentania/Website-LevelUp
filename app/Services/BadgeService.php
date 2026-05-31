<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\BadgeRepositoryInterface;

class BadgeService
{
    public function __construct(
        private BadgeRepositoryInterface $badgeRepo,
    ) {}

    /**
     * Check all badge criteria and award any newly earned badges.
     */
    public function checkAndAward(User $user): void
    {
        $badges = $this->badgeRepo->getAll();
        $completed = $user->mahasiswaProfile?->missions_completed ?? 0;

        foreach ($badges as $badge) {
            if ($this->badgeRepo->hasBadge($user->id, $badge->id)) {
                continue;
            }

            if ($this->meetsCriteria($user, $badge, $completed)) {
                $this->badgeRepo->awardBadge($user->id, $badge->id);
            }
        }
    }

    /**
     * Evaluate whether a user meets the criteria for a specific badge.
     */
    private function meetsCriteria(User $user, $badge, int $completed): bool
    {
        // XP/poin-based rank badges
        if ($badge->type === 'xp_rank') {
            $totalPoints = $user->mahasiswaProfile?->total_points ?? 0;
            return $totalPoints >= $badge->required_value;
        }

        return match ($badge->slug) {
            'first-step'          => $completed >= 1,
            'rising-star'         => $completed >= 5,
            'digital-hero'        => $completed >= 10,
            'community-champion'  => $completed >= 25,
            'design-wizard'       => $this->categoryCount($user, 'desain-poster') >= 5,
            'web-builder'         => $this->categoryCount($user, 'landing-page') >= 5,
            'social-guru'         => $this->categoryCount($user, 'social-media') >= 5,
            'data-master'         => $this->categoryCount($user, 'excel') >= 5,
            'five-star-performer' => $user->getAverageRating() >= 4.5 && $completed >= 3,
            'speed-demon'         => $this->hasEarlyCompletion($user),
            default               => false,
        };
    }

    /**
     * Count completed missions in a specific category.
     */
    private function categoryCount(User $user, string $category): int
    {
        return $user->portfolios()->where('category', $category)->count();
    }

    /**
     * Check if user has any early completion (before deadline).
     */
    private function hasEarlyCompletion(User $user): bool
    {
        return $user->portfolios()
            ->whereHas('mission', function ($q) {
                $q->whereColumn('portfolios.completed_at', '<', 'missions.deadline');
            })
            ->exists();
    }
}
