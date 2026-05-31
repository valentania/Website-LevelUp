<?php

namespace App\Policies;

use App\Models\MissionProgress;
use App\Models\User;

class MissionProgressPolicy
{
    /**
     * Only the mahasiswa owner can update their progress.
     */
    public function update(User $user, MissionProgress $progress): bool
    {
        return $user->id === $progress->user_id;
    }

    /**
     * Only the UMKM mission owner can approve/request revision.
     */
    public function approve(User $user, MissionProgress $progress): bool
    {
        return $user->id === $progress->mission->user_id;
    }

    /**
     * Only the mahasiswa owner or UMKM mission owner can view.
     */
    public function view(User $user, MissionProgress $progress): bool
    {
        return $user->id === $progress->user_id
            || $user->id === $progress->mission->user_id
            || $user->isAdmin();
    }
}
