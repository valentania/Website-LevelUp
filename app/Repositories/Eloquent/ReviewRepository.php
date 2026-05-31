<?php

namespace App\Repositories\Eloquent;

use App\Models\MissionReview;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function __construct(private MissionReview $model) {}

    public function create(array $data): MissionReview
    {
        return $this->model->create($data);
    }

    public function getByReviewee(int $userId): Collection
    {
        return $this->model
            ->with(['mission', 'reviewer'])
            ->where('reviewee_id', $userId)
            ->latest()
            ->get();
    }

    public function getAverageRating(int $userId): float
    {
        return round($this->model->where('reviewee_id', $userId)->avg('rating') ?? 0, 1);
    }
}
