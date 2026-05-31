<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionApplication;
use App\Notifications\ApplicationAcceptedNotification;
use App\Notifications\ApplicationRejectedNotification;
use App\Services\ApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    public function __construct(
        private ApplicationService $applicationService,
    ) {}

    public function index(Request $request, Mission $mission): View
    {
        $this->authorize('selectApplicant', $mission);
        $mission->load(['applications.mahasiswa.mahasiswaProfile', 'applications.mahasiswa.skills']);
        $applications = $mission->applications;

        return view('umkm.applicants.index', compact('mission', 'applications'));
    }

    public function accept(Request $request, Mission $mission, MissionApplication $application): RedirectResponse
    {
        $this->authorize('selectApplicant', $mission);
        $this->applicationService->acceptApplicant($application);

        // Notify mahasiswa
        $application->mahasiswa->notify(new ApplicationAcceptedNotification($mission));

        return redirect()->route('umkm.missions.show', $mission)
            ->with('success', 'Pelamar berhasil diterima! Mission sekarang sedang dikerjakan.');
    }

    public function reject(Request $request, Mission $mission, MissionApplication $application): RedirectResponse
    {
        $this->authorize('selectApplicant', $mission);
        $this->applicationService->rejectApplicant($application);

        // Notify mahasiswa
        $application->mahasiswa->notify(new ApplicationRejectedNotification($mission));

        return redirect()->route('umkm.missions.applicants', $mission)
            ->with('success', 'Pelamar ditolak.');
    }
}
