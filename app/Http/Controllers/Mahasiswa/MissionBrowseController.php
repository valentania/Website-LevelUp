<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MissionBrowseController extends Controller
{
    public function __construct(
        private MissionRepositoryInterface $missionRepo,
    ) {}

    public function index(Request $request): View
    {
        $keyword = $request->query('search', '');
        $filters = [
            'category' => $request->query('category'),
            'complexity' => $request->query('complexity'),
        ];

        $missions = $keyword || array_filter($filters)
            ? $this->missionRepo->search($keyword, $filters)
            : $this->missionRepo->getOpenMissions();

        return view('mahasiswa.missions.browse', [
            'missions' => $missions,
            'search' => $keyword,
            'filters' => $filters,
            'categories' => \App\Enums\MissionCategoryEnum::cases(),
            'complexities' => \App\Enums\ComplexityLevelEnum::cases(),
        ]);
    }

    public function show(\App\Models\Mission $mission): View
    {
        $mission->load(['creator.umkmProfile', 'applications']);
        $hasApplied = auth()->user()->applications()->where('mission_id', $mission->id)->exists();

        return view('mahasiswa.missions.show', [
            'mission' => $mission,
            'hasApplied' => $hasApplied,
        ]);
    }
}
