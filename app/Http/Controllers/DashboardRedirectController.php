<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardRedirectController extends Controller
{
    /**
     * Redirect authenticated user to their role-specific dashboard.
     */
    public function index(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            RoleEnum::ADMIN => redirect()->route('admin.dashboard'),
            RoleEnum::MAHASISWA => redirect()->route('mahasiswa.dashboard'),
            RoleEnum::UMKM => redirect()->route('umkm.dashboard'),
        };
    }
}
