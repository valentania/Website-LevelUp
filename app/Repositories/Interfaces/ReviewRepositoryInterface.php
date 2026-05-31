<?php

namespace App\Repositories\Interfaces;

use App\Models\MissionReview;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface
{
    public function create(array $data): MissionReview;
    public function getByReviewee(int $userId): Collection;
    public function getAverageRating(int $userId): float;
}
