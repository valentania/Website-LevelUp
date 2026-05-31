<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Notifications\MissionApprovedNotification;
use App\Notifications\MissionRejectedNotification;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Services\MissionService;
use App\Enums\MissionStatusEnum;
use App\Enums\ComplexityLevelEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MissionModerationController extends Controller
{
    public function __construct(
        private MissionRepositoryInterface $missionRepo,
        private MissionService $missionService,
    ) {}

    public function index(Request $request): View
    {
        $query = Mission::with(['creator.umkmProfile', 'applications'])
            ->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // Default: show pending first, then all others
            $query->orderByRaw("CASE WHEN status = 'pending_review' THEN 0 ELSE 1 END");
        }

        $missions = $query->paginate(15);

        return view('admin.missions.index', compact('missions'));
    }

    public function show(Mission $mission): View
    {
        $mission->load(['creator.umkmProfile', 'applications', 'progress', 'review']);
        return view('admin.missions.show', compact('mission'));
    }

    public function approve(Request $request, Mission $mission): RedirectResponse
    {
        $this->authorize('moderate', $mission);

        $request->validate([
            'complexity' => 'required|in:easy,medium,hard',
        ], [
            'complexity.required' => 'Silakan pilih tingkat kesulitan mission.',
        ]);

        // Set difficulty (admin only)
        $mission->update([
            'complexity' => ComplexityLevelEnum::from($request->complexity),
        ]);

        $this->missionService->approveMission($mission->id, $request->user());

        // Notify UMKM creator
        $mission->refresh()->load('creator');
        $mission->creator->notify(new MissionApprovedNotification($mission));

        return redirect()->route('admin.missions.index')
            ->with('success', "Mission \"{$mission->title}\" berhasil diapprove dengan tingkat kesulitan " . ucfirst($request->complexity) . ".");
    }

    public function reject(Request $request, Mission $mission): RedirectResponse
    {
        $this->authorize('moderate', $mission);

        $request->validate(['rejection_reason' => 'required|string|min:10|max:500']);

        $this->missionService->rejectMission($mission->id, $request->rejection_reason, $request->user());

        // Notify UMKM creator
        $mission->refresh()->load('creator');
        $mission->creator->notify(new MissionRejectedNotification($mission));

        return redirect()->route('admin.missions.index')
            ->with('success', "Mission \"{$mission->title}\" berhasil ditolak.");
    }

    public function destroy(Mission $mission): RedirectResponse
    {
        $this->authorize('moderate', $mission);
        $this->missionRepo->delete($mission->id);

        return redirect()->route('admin.missions.index')
            ->with('success', 'Mission berhasil dihapus.');
    }
}
