<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Enums\ProgressStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\MissionProgress;
use App\Notifications\ProjectSubmittedNotification;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function __construct(
        private ProgressRepositoryInterface $progressRepo,
        private \App\Services\PointService $pointService,
    ) {}

    public function show(MissionProgress $progress): View
    {
        $this->authorize('view', $progress);
        $progress->load(['mission.creator.umkmProfile', 'mahasiswa']);

        return view('mahasiswa.progress.show', compact('progress'));
    }

    public function update(Request $request, MissionProgress $progress): RedirectResponse
    {
        $this->authorize('update', $progress);

        $request->validate([
            'progress_note'   => 'required|string|min:10',
            'submission_link' => 'nullable|url|max:500',
            'attachment'      => 'nullable|file|mimes:pdf,zip,png,jpg,jpeg|max:10240',
            'action'          => 'required|in:save,submit',
        ]);

        $data = [
            'progress_note'   => $request->progress_note,
            'submission_link' => $request->submission_link,
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('progress', 'public');
        }

        $message = '';
        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $progress, $data, &$message) {
            if ($request->action === 'submit') {
                $data['status']       = ProgressStatusEnum::SUBMITTED->value;
                $data['submitted_at'] = now();
                $message = 'Hasil project berhasil dikirim dan menunggu review UMKM.';
            } else {
                $message = 'Draft berhasil disimpan.';
            }

            $this->progressRepo->update($progress->id, $data);

            // Notify UMKM when submitted
            if ($request->action === 'submit') {
                $progress->refresh()->load(['mission.creator', 'mahasiswa']);
                $progress->mission->creator->notify(new ProjectSubmittedNotification($progress));
            }
        });

        return back()->with('success', $message);
    }

    public function submitFinal(Request $request, MissionProgress $progress, \App\Services\PointService $pointService): RedirectResponse
    {
        $this->authorize('update', $progress);

        $request->validate([
            'progress_note'   => 'required|string|min:10',
            'submission_link' => 'nullable|url|max:500',
            'attachment'      => 'nullable|file|mimes:pdf,zip,png,jpg,jpeg|max:10240',
        ]);

        $data = [
            'progress_note'   => $request->progress_note,
            'submission_link' => $request->submission_link,
            'status'          => ProgressStatusEnum::FINAL_SUBMITTED->value,
            'submitted_at'    => now(),
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('progress', 'public');
        }
        \Illuminate\Support\Facades\DB::transaction(function () use ($progress, $data) {
            $this->progressRepo->update($progress->id, $data);

            // Notify UMKM of final submission
            $progress->refresh()->load(['mission.creator', 'mahasiswa']);
            $progress->mission->creator->notify(new ProjectSubmittedNotification($progress));
        });

        return back()->with('success', 'Hasil akhir berhasil disubmit dan menunggu persetujuan UMKM.');
    }
}
