<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private MissionRepositoryInterface $missionRepo,
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('umkm.dashboard', [
            'user' => $user->load('umkmProfile'),
            'missions' => $this->missionRepo->getByCreator($user->id, 5),
        ]);
    }
}
