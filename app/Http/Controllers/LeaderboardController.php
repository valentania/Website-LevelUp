<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        $topMahasiswa = User::where('role', 'mahasiswa')
            ->whereHas('mahasiswaProfile')
            ->with(['mahasiswaProfile', 'badges'])
            ->get()
            ->sortByDesc(fn ($u) => $u->mahasiswaProfile->total_points)
            ->take(20);

        return view('leaderboard', [
            'topMahasiswa' => $topMahasiswa,
        ]);
    }
}
