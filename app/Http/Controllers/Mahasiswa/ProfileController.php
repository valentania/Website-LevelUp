<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load(['mahasiswaProfile', 'skills']);

        return view('mahasiswa.profile.edit', [
            'user'    => $user,
            'profile' => $user->mahasiswaProfile,
            'allSkills' => Skill::orderBy('name')->get(),
            'userSkillIds' => $user->skills->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                    => 'required|string|max:255',
            'university'              => 'nullable|string|max:255',
            'major'                   => 'nullable|string|max:255',
            'student_id'              => 'nullable|string|max:50',
            'semester'                => 'nullable|integer|min:1|max:14',
            'bio'                     => 'nullable|string|max:1000',
            'phone'                   => 'nullable|string|max:20',
            'city'                    => 'nullable|string|max:100',
            'linkedin_url'            => 'nullable|url|max:255',
            'github_url'              => 'nullable|url|max:255',
            'portfolio_url'           => 'nullable|url|max:255',
            'instagram_url'           => 'nullable|url|max:255',
            'skills'                  => 'nullable|string|max:500',
            'interest_fields'         => 'nullable|string|max:500',
            'organization_experience' => 'nullable|string|max:2000',
            'project_experience'      => 'nullable|string|max:2000',
            'work_experience'         => 'nullable|string|max:2000',
            'certificates'            => 'nullable|string|max:1000',
            'cv_file'                 => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $user = $request->user();
        $user->update(['name' => $request->name]);

        $profileData = $request->only([
            'university', 'major', 'student_id', 'semester', 'bio', 'phone', 'city',
            'linkedin_url', 'github_url', 'portfolio_url', 'instagram_url',
            'skills', 'interest_fields',
            'organization_experience', 'project_experience', 'work_experience', 'certificates',
        ]);

        if ($request->hasFile('cv_file')) {
            $profileData['cv_path'] = $request->file('cv_file')->store('cvs', 'public');
        }

        $user->mahasiswaProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('mahasiswa.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
