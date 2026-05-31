<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;

class PortfolioPolicy
{
    /**
     * Anyone can view portfolios (public showcase).
     */
    public function view(?User $user, Portfolio $portfolio): bool
    {
        return true;
    }

    /**
     * Only the owner can manage their portfolio (toggle featured, etc).
     */
    public function update(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }
}
