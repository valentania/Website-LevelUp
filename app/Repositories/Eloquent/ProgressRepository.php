<?php

namespace App\Repositories\Eloquent;

use App\Enums\ProgressStatusEnum;
use App\Models\MissionProgress;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProgressRepository implements ProgressRepositoryInterface
{
    public function __construct(private MissionProgress $model) {}

    public function findById(int $id): ?MissionProgress
    {
        return $this->model->with(['mission.creator', 'mahasiswa'])->find($id);
    }

    public function create(array $data): MissionProgress
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data) > 0;
    }

    public function getByMahasiswa(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('mission')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function getByMission(int $missionId): ?MissionProgress
    {
        return $this->model
            ->with(['mahasiswa', 'application'])
            ->where('mission_id', $missionId)
            ->first();
    }

    public function updateStatus(int $id, ProgressStatusEnum $status): bool
    {
        return $this->model->where('id', $id)->update(['status' => $status->value]) > 0;
    }
}
