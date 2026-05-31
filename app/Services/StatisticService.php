<?php

namespace App\Services;

use App\Enums\MissionStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Mission;
use App\Models\MissionReview;
use App\Models\PointHistory;
use App\Models\User;

class StatisticService
{
    /**
     * Get comprehensive platform statistics for admin dashboard.
     */
    public function getPlatformStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_mahasiswa' => User::where('role', RoleEnum::MAHASISWA)->count(),
            'total_umkm' => User::where('role', RoleEnum::UMKM)->count(),
            'total_missions' => Mission::count(),
            'completed_missions' => Mission::where('status', MissionStatusEnum::COMPLETED)->count(),
            'active_missions' => Mission::where('status', MissionStatusEnum::IN_PROGRESS)->count(),
            'open_missions' => Mission::where('status', MissionStatusEnum::OPEN)->count(),
            'pending_missions' => Mission::where('status', MissionStatusEnum::PENDING_REVIEW)->count(),
            'total_points_distributed' => PointHistory::sum('points'),
            'average_rating' => round(MissionReview::avg('rating') ?? 0, 1),
        ];
    }

    /**
     * Get social impact statistics.
     */
    public function getSocialImpact(): array
    {
        return [
            'umkm_helped' => Mission::where('status', MissionStatusEnum::COMPLETED)
                ->distinct('user_id')
                ->count('user_id'),
            'mahasiswa_active' => User::where('role', RoleEnum::MAHASISWA)
                ->whereHas('portfolios')
                ->count(),
            'total_contributions' => Mission::where('status', MissionStatusEnum::COMPLETED)->count(),
            'total_reviews' => MissionReview::count(),
        ];
    }
}
