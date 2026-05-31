<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Services\StatisticService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private StatisticService $statisticService,
        private MissionRepositoryInterface $missionRepo,
    ) {}

    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => $this->statisticService->getPlatformStats(),
            'impact' => $this->statisticService->getSocialImpact(),
            'pendingMissions' => $this->missionRepo->getPendingReview(5),
        ]);
    }
}
