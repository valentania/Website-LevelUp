<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        // Use database-level JOIN + ORDER BY for accurate, real-time ranking.
        // Previously used ->get()->sortByDesc() which fetches all users first,
        // then sorts in PHP — results can be inaccurate if profile data is stale.
        $topMahasiswa = User::where('users.role', 'mahasiswa')
            ->join('mahasiswa_profiles', 'mahasiswa_profiles.user_id', '=', 'users.id')
            ->select('users.*', 'mahasiswa_profiles.total_points as ranked_points')
            ->orderByDesc('mahasiswa_profiles.total_points')
            ->take(20)
            ->with(['mahasiswaProfile', 'badges'])
            ->get()
            ->values(); // Reset collection index so rank = index + 1

        return view('leaderboard', [
            'topMahasiswa' => $topMahasiswa,
        ]);
    }
}
