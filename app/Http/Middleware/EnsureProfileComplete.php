<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Redirect users to profile completion if their profile is incomplete.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Skip if already on profile edit page
        if ($request->routeIs('*.profile.edit') || $request->routeIs('*.profile.update')) {
            return $next($request);
        }

        if ($user->isMahasiswa() && !$user->mahasiswaProfile?->university) {
            return redirect()->route('mahasiswa.profile.edit')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        if ($user->isUmkm() && !$user->umkmProfile?->business_name) {
            return redirect()->route('umkm.profile.edit')
                ->with('warning', 'Silakan lengkapi profil bisnis Anda terlebih dahulu.');
        }

        return $next($request);
    }
}
