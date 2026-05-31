<?php

namespace App\Http\Controllers\Umkm;

use App\Enums\MissionCategoryEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mission\StoreMissionRequest;
use App\Models\Mission;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Services\MissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MissionController extends Controller
{
    public function __construct(
        private MissionRepositoryInterface $missionRepo,
        private MissionService $missionService,
    ) {}

    public function index(Request $request): View
    {
        return view('umkm.missions.index', [
            'missions' => $this->missionRepo->getByCreator($request->user()->id, 10),
        ]);
    }

    public function create(): View
    {
        return view('umkm.missions.create', [
            'categories' => MissionCategoryEnum::cases(),
        ]);
    }

    public function store(StoreMissionRequest $request): RedirectResponse
    {
        $mission = $this->missionService->createMission(
            $request->user(),
            $request->validated()
        );

        $message = $mission->status->value === 'rejected'
            ? 'Mission ditolak otomatis karena terlalu kompleks: ' . $mission->rejection_reason
            : 'Mission berhasil dibuat dan menunggu review admin.';

        return redirect()->route('umkm.missions.index')
            ->with($mission->status->value === 'rejected' ? 'error' : 'success', $message);
    }

    public function show(Mission $mission): View
    {
        $this->authorize('view', $mission);
        $mission->load(['applications.mahasiswa.mahasiswaProfile', 'progress.mahasiswa.mahasiswaProfile', 'progress.messages.sender', 'review']);

        return view('umkm.missions.show', compact('mission'));
    }

    public function edit(Mission $mission): View
    {
        $this->authorize('update', $mission);

        return view('umkm.missions.edit', [
            'mission' => $mission,
            'categories' => MissionCategoryEnum::cases(),
        ]);
    }

    public function update(StoreMissionRequest $request, Mission $mission): RedirectResponse
    {
        $this->authorize('update', $mission);

        $data = collect($request->validated())
            ->except(['skill_tags']) // form-only, not a DB column
            ->toArray();

        $this->missionRepo->update($mission->id, $data);

        return redirect()->route('umkm.missions.show', $mission)
            ->with('success', 'Mission berhasil diperbarui.');
    }

    public function destroy(Mission $mission): RedirectResponse
    {
        $this->authorize('delete', $mission);
        $this->missionRepo->delete($mission->id);

        return redirect()->route('umkm.missions.index')
            ->with('success', 'Mission berhasil dihapus.');
    }
}
