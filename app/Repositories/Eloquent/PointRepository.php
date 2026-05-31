<?php

namespace App\Repositories\Eloquent;

use App\Models\PointHistory;
use App\Repositories\Interfaces\PointRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class PointRepository implements PointRepositoryInterface
{
    public function __construct(private PointHistory $model) {}

    public function addPoints(int $userId, int $points, string $type, string $description, ?Model $reference = null): PointHistory
    {
        $data = [
            'user_id' => $userId,
            'points' => $points,
            'type' => $type,
            'description' => $description,
        ];

        if ($reference) {
            $data['reference_id'] = $reference->getKey();
            $data['reference_type'] = get_class($reference);
        }

        return $this->model->create($data);
    }

    public function getTotalPoints(int $userId): int
    {
        return (int) $this->model->where('user_id', $userId)->sum('points');
    }

    public function getHistory(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }
}
