<?php

namespace App\Services;

use App\Enums\MissionStatusEnum;
use App\Models\Mission;
use App\Models\User;
use App\Repositories\Interfaces\MissionRepositoryInterface;

class MissionService
{
    public function __construct(
        private MissionRepositoryInterface $missionRepo,
    ) {}

    /**
     * Create a new mission.
     * UMKM may suggest a complexity level; admin validates/overrides during approval.
     */
    public function createMission(User $user, array $data): Mission
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $data) {
            $data['user_id'] = $user->id;

            // skill_tags is a form-only field (not a DB column) — strip it out
            unset($data['skill_tags']);

            // Complexity is optional — null means "admin will decide"
            if (empty($data['complexity'])) {
                $data['complexity'] = null;
            }

            // Points are set by admin on approval; use 0 as placeholder
            if (!empty($data['complexity'])) {
                $cx = \App\Enums\ComplexityLevelEnum::tryFrom($data['complexity']);
                $data['points_reward'] = $cx ? $cx->points() : 0;
            } else {
                $data['points_reward'] = 0; // placeholder, set by admin on approve
            }

            $data['status'] = MissionStatusEnum::PENDING_REVIEW->value;

            $mission = $this->missionRepo->create($data);

            // Update UMKM profile counter
            $user->umkmProfile?->increment('missions_posted');

            return $mission;
        });
    }

    /**
     * Admin approves a mission, making it open for applications.
     * The complexity is already set by the approve controller before calling this.
     */
    public function approveMission(int $missionId, User $admin): bool
    {
        $mission = Mission::find($missionId);

        // Recalculate points based on the admin-validated complexity
        $pointsReward = $mission?->complexity?->points() ?? 10;

        return $this->missionRepo->update($missionId, [
            'status'       => MissionStatusEnum::OPEN->value,
            'points_reward'=> $pointsReward,
            'approved_by'  => $admin->id,
            'approved_at'  => now(),
        ]);
    }

    /**
     * Admin rejects a mission with a reason.
     */
    public function rejectMission(int $missionId, string $reason, User $admin): bool
    {
        return $this->missionRepo->update($missionId, [
            'status' => MissionStatusEnum::REJECTED->value,
            'rejection_reason' => $reason,
            'approved_by' => $admin->id,
        ]);
    }

    /**
     * Complete a mission — triggers portfolio generation and point awarding.
     */
    public function completeMission(int $missionId): bool
    {
        return $this->missionRepo->updateStatus($missionId, MissionStatusEnum::COMPLETED);
    }
}
