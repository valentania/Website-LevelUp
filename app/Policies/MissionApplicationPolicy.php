<?php

namespace App\Policies;

use App\Enums\ApplicationStatusEnum;
use App\Models\MissionApplication;
use App\Models\User;

class MissionApplicationPolicy
{
    /**
     * Only mahasiswa can apply to missions.
     */
    public function create(User $user): bool
    {
        return $user->isMahasiswa();
    }

    /**
     * Only the applicant can view their application details.
     */
    public function view(User $user, MissionApplication $application): bool
    {
        return $user->id === $application->user_id
            || $user->id === $application->mission->user_id
            || $user->isAdmin();
    }

    /**
     * Only the applicant can withdraw (while pending).
     */
    public function withdraw(User $user, MissionApplication $application): bool
    {
        return $user->id === $application->user_id
            && $application->status === ApplicationStatusEnum::PENDING;
    }
}
