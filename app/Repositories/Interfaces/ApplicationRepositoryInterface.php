<?php

namespace App\Repositories\Interfaces;

use App\Enums\ApplicationStatusEnum;
use App\Models\MissionApplication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationRepositoryInterface
{
    public function findById(int $id): ?MissionApplication;
    public function create(array $data): MissionApplication;
    public function getByMission(int $missionId): Collection;
    public function getByMahasiswa(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function updateStatus(int $id, ApplicationStatusEnum $status): bool;
    public function hasApplied(int $userId, int $missionId): bool;
}
