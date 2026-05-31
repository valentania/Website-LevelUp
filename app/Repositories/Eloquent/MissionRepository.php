<?php

namespace App\Repositories\Eloquent;

use App\Enums\MissionStatusEnum;
use App\Models\Mission;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MissionRepository implements MissionRepositoryInterface
{
    public function __construct(private Mission $model) {}

    public function findById(int $id): ?Mission
    {
        return $this->model
            ->with(['creator.umkmProfile', 'applications.mahasiswa', 'progress', 'review'])
            ->find($id);
    }

    public function create(array $data): Mission
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->model->where('id', $id)->delete() > 0;
    }

    public function getOpenMissions(int $perPage = 12): LengthAwarePaginator
    {
        return $this->model
            ->with('creator.umkmProfile')
            ->open()
            ->latest()
            ->paginate($perPage);
    }

    public function getByCategory(string $category, int $perPage = 12): LengthAwarePaginator
    {
        return $this->model
            ->with('creator.umkmProfile')
            ->open()
            ->byCategory($category)
            ->latest()
            ->paginate($perPage);
    }

    public function getByCreator(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with(['applications', 'progress'])
            ->forUmkm($userId)
            ->latest()
            ->paginate($perPage);
    }

    public function getPendingReview(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('creator.umkmProfile')
            ->pendingReview()
            ->latest()
            ->paginate($perPage);
    }

    public function updateStatus(int $id, MissionStatusEnum $status): bool
    {
        return $this->update($id, ['status' => $status->value]);
    }

    public function search(string $keyword, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        return $this->model
            ->with('creator.umkmProfile')
            ->open()
            ->when($keyword, fn ($q) => $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%"))
            ->when($filters['category'] ?? null, fn ($q, $cat) => $q->byCategory($cat))
            ->when($filters['complexity'] ?? null, fn ($q, $level) => $q->byComplexity($level))
            ->latest()
            ->paginate($perPage);
    }
}
