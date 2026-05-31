<?php

namespace App\Policies;

use App\Models\Mission;
use App\Models\MissionProgress;
use App\Models\User;

class MissionProgressPolicy
{
    /**
     * Only the mahasiswa owner can update their progress.
     */
    public function update(User $user, MissionProgress $progress): bool
    {
        return (int) $user->id === (int) $progress->user_id;
    }

    /**
     * Only the UMKM mission owner can approve/request revision.
     * Safe against soft-deleted missions via withTrashed().
     */
    public function approve(User $user, MissionProgress $progress): bool
    {
        $missionOwnerId = Mission::withTrashed()
            ->where('id', $progress->mission_id)
            ->value('user_id');

        return $missionOwnerId !== null
            && (int) $user->id === (int) $missionOwnerId;
    }

    /**
     * Mahasiswa owner, UMKM mission owner, or admin can view.
     * Safe against soft-deleted missions via withTrashed().
     */
    public function view(User $user, MissionProgress $progress): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ((int) $user->id === (int) $progress->user_id) {
            return true;
        }

        if ($user->isUmkm() && $progress->mission_id) {
            $missionOwnerId = Mission::withTrashed()
                ->where('id', $progress->mission_id)
                ->value('user_id');

            return $missionOwnerId !== null
                && (int) $user->id === (int) $missionOwnerId;
        }

        return false;
    }
}
