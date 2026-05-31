<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\User;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Interfaces\PointRepositoryInterface;

class PointService
{
    private const REVIEW_BONUS_5STAR = 5;
    private const EARLY_COMPLETION_BONUS = 10;

    public function __construct(
        private PointRepositoryInterface $pointRepo,
        private BadgeService $badgeService,
    ) {}

    /**
     * Award points to mahasiswa for completing a mission.
     */
    public function awardMissionPoints(User $user, Mission $mission): void
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($user, $mission) {
            $points = $mission->points_reward;

            $this->pointRepo->addPoints(
                $user->id,
                $points,
                'mission_completed',
                "Menyelesaikan mission: {$mission->title}",
                $mission
            );

            // Update profile counters
            $user->mahasiswaProfile?->increment('total_points', $points);
            $user->mahasiswaProfile?->increment('missions_completed');

            // Check for new badges
            $this->badgeService->checkAndAward($user);
        });
    }

    /**
     * Award bonus points for receiving a 5-star review.
     */
    public function awardReviewBonus(User $user, int $rating, Mission $mission): void
    {
        if ($rating >= 5) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($user, $rating, $mission) {
                $this->pointRepo->addPoints(
                    $user->id,
                    self::REVIEW_BONUS_5STAR,
                    'review_bonus',
                    "Bonus rating bintang 5 dari mission: {$mission->title}",
                    $mission
                );

                $user->mahasiswaProfile?->increment('total_points', self::REVIEW_BONUS_5STAR);
            });
        }
    }

    /**
     * Award bonus for early completion (before deadline).
     */
    public function awardEarlyCompletionBonus(User $user, Mission $mission): void
    {
        if ($mission->deadline && now()->lt($mission->deadline)) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($user, $mission) {
                $this->pointRepo->addPoints(
                    $user->id,
                    self::EARLY_COMPLETION_BONUS,
                    'bonus',
                    "Bonus selesai sebelum deadline: {$mission->title}",
                    $mission
                );

                $user->mahasiswaProfile?->increment('total_points', self::EARLY_COMPLETION_BONUS);
            });
        }
    }
}
