<?php

namespace App\Repositories\Interfaces;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function getAllByRole(RoleEnum $role, int $perPage = 15): LengthAwarePaginator;
    public function getAll(int $perPage = 15): LengthAwarePaginator;
    public function update(int $id, array $data): bool;
    public function suspend(int $id): bool;
    public function unsuspend(int $id): bool;
    public function getStatsByRole(): array;
}
