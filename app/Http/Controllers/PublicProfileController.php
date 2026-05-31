<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    public function show(User $user): View
    {
        if ($user->isMahasiswa()) {
            $user->load(['mahasiswaProfile', 'skills', 'portfolios' => function($q) {
                $q->latest();
            }]);
            return view('profile.mahasiswa.show', compact('user'));
        }

        if ($user->isUmkm()) {
            $user->load(['umkmProfile', 'missions' => function($q) use ($user) {
                if (auth()->id() === $user->id) {
                    $q->where('status', '!=', 'rejected')->latest()->take(10);
                } else {
                    $q->whereIn('status', ['open', 'completed'])->latest()->take(10);
                }
            }]);
            return view('profile.umkm.show', compact('user'));
        }

        abort(404);
    }
}
