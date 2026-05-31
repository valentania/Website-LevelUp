<?php

namespace App\Policies;

use App\Enums\MissionStatusEnum;
use App\Models\Mission;
use App\Models\MissionReview;
use App\Models\User;

class MissionReviewPolicy
{
    /**
     * Only the UMKM mission owner can create a review (after completion).
     */
    public function create(User $user, Mission $mission): bool
    {
        return $user->id === $mission->user_id
            && $mission->status === MissionStatusEnum::COMPLETED
            && !$mission->review()->exists();
    }
}
