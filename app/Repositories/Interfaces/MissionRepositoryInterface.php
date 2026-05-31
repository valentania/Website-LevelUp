<?php

namespace App\Repositories\Interfaces;

use App\Enums\MissionStatusEnum;
use App\Models\Mission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MissionRepositoryInterface
{
    public function findById(int $id): ?Mission;
    public function create(array $data): Mission;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getOpenMissions(int $perPage = 12): LengthAwarePaginator;
    public function getByCategory(string $category, int $perPage = 12): LengthAwarePaginator;
    public function getByCreator(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function getPendingReview(int $perPage = 10): LengthAwarePaginator;
    public function updateStatus(int $id, MissionStatusEnum $status): bool;
    public function search(string $keyword, array $filters = [], int $perPage = 12): LengthAwarePaginator;
}
