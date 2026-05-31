<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\MissionReview;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Interfaces\PortfolioRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private ApplicationRepositoryInterface $appRepo,
        private ProgressRepositoryInterface $progressRepo,
        private BadgeRepositoryInterface $badgeRepo,
        private PortfolioRepositoryInterface $portfolioRepo,
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        // Fetch reviews received by this mahasiswa (as reviewee)
        $reviews = MissionReview::with(['reviewer.umkmProfile', 'mission'])
            ->where('reviewee_id', $user->id)
            ->latest()
            ->get();

        return view('mahasiswa.dashboard', [
            'user'               => $user->load('mahasiswaProfile'),
            'activeProgress'     => $this->progressRepo->getByMahasiswa($user->id, 5),
            'badges'             => $this->badgeRepo->getUserBadges($user->id),
            'recentApplications' => $this->appRepo->getByMahasiswa($user->id, 5),
            'reviews'            => $reviews,
        ]);
    }
}
