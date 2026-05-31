<?php

namespace App\Repositories\Eloquent;

use App\Models\Portfolio;
use App\Repositories\Interfaces\PortfolioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PortfolioRepository implements PortfolioRepositoryInterface
{
    public function __construct(private Portfolio $model) {}

    public function create(array $data): Portfolio
    {
        return $this->model->create($data);
    }

    public function getByUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('mission')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Portfolio
    {
        return $this->model->with(['mission', 'user'])->find($id);
    }

    public function toggleFeatured(int $id): bool
    {
        $portfolio = $this->model->find($id);
        if (!$portfolio) return false;

        $portfolio->is_featured = !$portfolio->is_featured;
        return $portfolio->save();
    }
}
