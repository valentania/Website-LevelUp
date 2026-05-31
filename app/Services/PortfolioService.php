<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\Portfolio;
use App\Models\User;
use App\Repositories\Interfaces\PortfolioRepositoryInterface;

class PortfolioService
{
    public function __construct(
        private PortfolioRepositoryInterface $portfolioRepo,
    ) {}

    /**
     * Auto-generate a portfolio entry from a completed mission.
     */
    public function generateFromMission(Mission $mission, User $mahasiswa): Portfolio
    {
        $review = $mission->review;

        return $this->portfolioRepo->create([
            'user_id' => $mahasiswa->id,
            'mission_id' => $mission->id,
            'title' => $mission->title,
            'description' => $mission->description,
            'category' => $mission->category->value,
            'client_name' => $mission->creator->umkmProfile?->business_name
                ?? $mission->creator->name,
            'rating' => $review?->rating,
            'client_testimonial' => $review?->comment,
            'completed_at' => now(),
            'attachment_path' => $mission->progress?->attachment_path,
        ]);
    }
}
