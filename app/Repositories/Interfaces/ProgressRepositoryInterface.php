<?php

namespace App\Repositories\Interfaces;

use App\Enums\ProgressStatusEnum;
use App\Models\MissionProgress;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProgressRepositoryInterface
{
    public function findById(int $id): ?MissionProgress;
    public function create(array $data): MissionProgress;
    public function update(int $id, array $data): bool;
    public function getByMahasiswa(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function getByMission(int $missionId): ?MissionProgress;
    public function updateStatus(int $id, ProgressStatusEnum $status): bool;
}
