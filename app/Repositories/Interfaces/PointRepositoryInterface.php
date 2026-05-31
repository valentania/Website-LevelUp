<?php

namespace App\Repositories\Interfaces;

use App\Models\PointHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface PointRepositoryInterface
{
    public function addPoints(int $userId, int $points, string $type, string $description, ?Model $reference = null): PointHistory;
    public function getTotalPoints(int $userId): int;
    public function getHistory(int $userId, int $perPage = 15): LengthAwarePaginator;
}
