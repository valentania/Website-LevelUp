<?php

namespace App\Repositories\Interfaces;

use App\Models\Portfolio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PortfolioRepositoryInterface
{
    public function create(array $data): Portfolio;
    public function getByUser(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function findById(int $id): ?Portfolio;
    public function toggleFeatured(int $id): bool;
}
