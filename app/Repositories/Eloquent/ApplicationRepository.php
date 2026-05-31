<?php

namespace App\Repositories\Eloquent;

use App\Enums\ApplicationStatusEnum;
use App\Models\MissionApplication;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function __construct(private MissionApplication $model) {}

    public function findById(int $id): ?MissionApplication
    {
        return $this->model->with(['mission', 'mahasiswa.mahasiswaProfile'])->find($id);
    }

    public function create(array $data): MissionApplication
    {
        return $this->model->create($data);
    }

    public function getByMission(int $missionId): Collection
    {
        return $this->model
            ->with('mahasiswa.mahasiswaProfile')
            ->where('mission_id', $missionId)
            ->latest()
            ->get();
    }

    public function getByMahasiswa(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('mission.creator')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function updateStatus(int $id, ApplicationStatusEnum $status): bool
    {
        return $this->model->where('id', $id)->update([
            'status' => $status->value,
            'responded_at' => now(),
        ]) > 0;
    }

    public function hasApplied(int $userId, int $missionId): bool
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('mission_id', $missionId)
            ->exists();
    }
}
