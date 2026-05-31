<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\StoreApplicationRequest;
use App\Models\Mission;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Services\ApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __construct(
        private ApplicationRepositoryInterface $appRepo,
        private ApplicationService $applicationService,
    ) {}

    public function index(Request $request): View
    {
        return view('mahasiswa.applications.index', [
            'applications' => $this->appRepo->getByMahasiswa($request->user()->id, 10),
        ]);
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        try {
            $mission = Mission::findOrFail($request->mission_id);
            $this->applicationService->apply($request->user(), $mission, $request->validated());

            return redirect()->route('mahasiswa.applications.index')
                ->with('success', 'Lamaran berhasil dikirim! Tunggu konfirmasi dari UMKM.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
