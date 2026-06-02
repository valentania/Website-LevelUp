<?php

namespace App\Policies;

use App\Enums\MissionStatusEnum;
use App\Models\Mission;
use App\Models\User;

class MissionPolicy
{
    /**
     * Anyone can view open missions.
     */
    public function view(?User $user, Mission $mission): bool
    {
        return true;
    }

    /**
     * Only UMKM can create missions.
     */
    public function create(User $user): bool
    {
        return $user->isUmkm();
    }

    /**
     * Only the UMKM creator can update (while draft or pending).
     */
    public function update(User $user, Mission $mission): bool
    {
        return $user->id === $mission->user_id
            && in_array($mission->status, [
                MissionStatusEnum::DRAFT,
                MissionStatusEnum::PENDING_REVIEW,
                MissionStatusEnum::OPEN,
                MissionStatusEnum::REJECTED,
            ]);
    }

    /**
     * Only the UMKM creator can delete (draft, pending, or rejected).
     * Note: missions are never actually created as 'draft' via the UI —
     * they go directly to 'pending_review'. Allowing rejected missions to
     * be deleted lets UMKM clean up declined submissions.
     */
    public function delete(User $user, Mission $mission): bool
    {
        return $user->id === $mission->user_id
            && in_array($mission->status, [
                MissionStatusEnum::DRAFT,
                MissionStatusEnum::PENDING_REVIEW,
                MissionStatusEnum::REJECTED,
            ]);
    }

    /**
     * Only admin can moderate (approve/reject) missions.
     */
    public function moderate(User $user, Mission $mission): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only the UMKM creator can select applicants.
     */
    public function selectApplicant(User $user, Mission $mission): bool
    {
        return $user->id === $mission->user_id
            && $mission->status === MissionStatusEnum::OPEN;
    }
}
