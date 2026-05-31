<?php

namespace App\Http\Controllers\Umkm;

use App\Enums\MissionStatusEnum;
use App\Enums\ProgressStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Models\Mission;
use App\Models\MissionProgress;
use App\Notifications\ProjectApprovedNotification;
use App\Notifications\RevisionRequestedNotification;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Services\MissionService;
use App\Services\PointService;
use App\Services\PortfolioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        private ProgressRepositoryInterface $progressRepo,
        private ReviewRepositoryInterface $reviewRepo,
        private MissionService $missionService,
        private PointService $pointService,
        private PortfolioService $portfolioService,
    ) {}

    public function requestRevision(Request $request, MissionProgress $progress): RedirectResponse
    {
        $this->authorize('approve', $progress);

        $request->validate(['revision_note' => 'required|string|min:10|max:500']);

        $this->progressRepo->update($progress->id, [
            'status' => ProgressStatusEnum::REVISION_REQUESTED->value,
            'revision_note' => $request->revision_note,
            'revision_count' => $progress->revision_count + 1,
        ]);

        // Notify mahasiswa
        $progress->load(['mission', 'mahasiswa']);
        $progress->mahasiswa->notify(new RevisionRequestedNotification($progress));

        return back()->with('success', 'Permintaan revisi berhasil dikirim.');
    }

    public function approve(Request $request, MissionProgress $progress): RedirectResponse
    {
        $this->authorize('approve', $progress);

        $mahasiswa = $progress->mahasiswa;

        \Illuminate\Support\Facades\DB::transaction(function () use ($progress, $mahasiswa) {
            $this->progressRepo->update($progress->id, [
                'status' => ProgressStatusEnum::APPROVED->value,
                'approved_at' => now(),
            ]);

            $this->missionService->completeMission($progress->mission_id);

            // Give points only when approved by UMKM
            $this->pointService->awardMissionPoints($mahasiswa, $progress->mission);
            $this->pointService->awardEarlyCompletionBonus($mahasiswa, $progress->mission);

            $this->portfolioService->generateFromMission($progress->mission, $mahasiswa);
        });

        // Notify mahasiswa
        $progress->load(['mission']);
        $mahasiswa->notify(new ProjectApprovedNotification($progress));

        return redirect()->route('umkm.missions.show', $progress->mission)
            ->with('success', 'Hasil mission disetujui! Mahasiswa telah mendapatkan poin. Silakan berikan review untuk mahasiswa.');
    }

    public function store(StoreReviewRequest $request, Mission $mission): RedirectResponse
    {
        $this->authorize('create', [\App\Models\MissionReview::class, $mission]);

        $mahasiswa = $mission->progress->mahasiswa;

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $mission, $mahasiswa) {
            $this->reviewRepo->create([
                'mission_id' => $mission->id,
                'reviewer_id' => $request->user()->id,
                'reviewee_id' => $mahasiswa->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'strengths' => $request->strengths,
                'improvements' => $request->improvements,
            ]);

            // Award review bonus points
            $this->pointService->awardReviewBonus($mahasiswa, $request->rating, $mission);
        });

        return redirect()->route('umkm.missions.show', $mission)
            ->with('success', 'Review berhasil diberikan! Mahasiswa mendapatkan bonus poin rating.');
    }
}
