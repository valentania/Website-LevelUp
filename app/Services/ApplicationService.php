<?php

namespace App\Services;

use App\Enums\ApplicationStatusEnum;
use App\Enums\MissionStatusEnum;
use App\Enums\ProgressStatusEnum;
use App\Models\Mission;
use App\Models\MissionApplication;
use App\Models\User;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;

class ApplicationService
{
    public function __construct(
        private ApplicationRepositoryInterface $appRepo,
        private ProgressRepositoryInterface $progressRepo,
        private MissionRepositoryInterface $missionRepo,
    ) {}

    /**
     * Mahasiswa applies to a mission.
     */
    public function apply(User $mahasiswa, Mission $mission, array $data): MissionApplication
    {
        if ($this->appRepo->hasApplied($mahasiswa->id, $mission->id)) {
            throw new \Exception('Anda sudah melamar mission ini.');
        }

        if ($mission->status !== MissionStatusEnum::OPEN) {
            throw new \Exception('Mission tidak sedang terbuka untuk lamaran.');
        }

        return $this->appRepo->create([
            'mission_id' => $mission->id,
            'user_id' => $mahasiswa->id,
            'cover_letter' => $data['cover_letter'] ?? null,
            'relevant_experience' => $data['relevant_experience'] ?? null,
            'status' => ApplicationStatusEnum::PENDING->value,
        ]);
    }

    /**
     * UMKM accepts an applicant and creates a progress record.
     */
    public function acceptApplicant(MissionApplication $application): void
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($application) {
            // Accept this application
            $this->appRepo->updateStatus($application->id, ApplicationStatusEnum::ACCEPTED);

            // Create progress record
            $this->progressRepo->create([
                'mission_id' => $application->mission_id,
                'user_id' => $application->user_id,
                'application_id' => $application->id,
                'status' => ProgressStatusEnum::IN_PROGRESS->value,
            ]);

            // Update mission status
            $this->missionRepo->updateStatus($application->mission_id, MissionStatusEnum::IN_PROGRESS);

            // Reject other pending applicants for this mission
            $otherApplications = $this->appRepo->getByMission($application->mission_id);
            foreach ($otherApplications as $other) {
                if ($other->id !== $application->id && $other->status === ApplicationStatusEnum::PENDING) {
                    $this->appRepo->updateStatus($other->id, ApplicationStatusEnum::REJECTED);
                }
            }
        });
    }

    /**
     * UMKM rejects an applicant.
     */
    public function rejectApplicant(MissionApplication $application): void
    {
        $this->appRepo->updateStatus($application->id, ApplicationStatusEnum::REJECTED);
    }
}
