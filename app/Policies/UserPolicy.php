<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Only admin can view all users.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only admin can suspend users.
     */
    public function suspend(User $user, User $target): bool
    {
        return $user->isAdmin() && $user->id !== $target->id;
    }

    /**
     * Only admin can unsuspend users.
     */
    public function unsuspend(User $user, User $target): bool
    {
        return $user->isAdmin();
    }
}
