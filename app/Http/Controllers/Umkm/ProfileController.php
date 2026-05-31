<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('umkmProfile');

        return view('umkm.profile.edit', [
            'user' => $user,
            'profile' => $user->umkmProfile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'business_name'        => 'required|string|max:255',
            'business_type'        => 'nullable|string|max:100',
            'business_description' => 'nullable|string|max:1000',
            'address'              => 'nullable|string|max:500',
            'city'                 => 'nullable|string|max:100',
            'phone'                => 'nullable|string|max:20',
            'website'              => 'nullable|url|max:255',
        ]);

        $user = $request->user();
        $user->update(['name' => $request->name]);

        $user->umkmProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['business_name', 'business_type', 'business_description', 'address', 'city', 'phone', 'website'])
        );

        return redirect()->route('umkm.profile.edit')
            ->with('success', 'Profil bisnis berhasil diperbarui!');
    }
}
