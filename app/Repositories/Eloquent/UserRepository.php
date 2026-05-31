<?php

namespace App\Repositories\Eloquent;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model) {}

    public function findById(int $id): ?User
    {
        return $this->model->with(['mahasiswaProfile', 'umkmProfile'])->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function getAllByRole(RoleEnum $role, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('role', $role)
            ->latest()
            ->paginate($perPage);
    }

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data) > 0;
    }

    public function suspend(int $id): bool
    {
        return $this->update($id, ['is_suspended' => true]);
    }

    public function unsuspend(int $id): bool
    {
        return $this->update($id, ['is_suspended' => false]);
    }

    public function getStatsByRole(): array
    {
        return [
            'total' => $this->model->count(),
            'admin' => $this->model->where('role', RoleEnum::ADMIN)->count(),
            'mahasiswa' => $this->model->where('role', RoleEnum::MAHASISWA)->count(),
            'umkm' => $this->model->where('role', RoleEnum::UMKM)->count(),
        ];
    }
}
