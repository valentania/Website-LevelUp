<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ route('umkm.missions.show', $mission) }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Mission
    </a>

    <div style="margin-bottom:2rem;">
        <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Pelamar Mission</h1>
        <p style="font-size:.875rem;color: #475569;">{{ $mission->title }}</p>
    </div>

    @if($applications->isEmpty())
        <div class="glass-card" style="padding:5rem 2rem;text-align:center;">
            <div class="empty-state-icon" style="margin:0 auto 1.5rem;">👥</div>
            <div class="empty-state-title">Belum Ada Pelamar</div>
            <div class="empty-state-desc">Mission ini belum mendapatkan pelamar. Tunggu sebentar!</div>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.25rem;">
            @foreach($applications as $app)
            @php
                $statusMap=['pending'=>['class'=>'badge-yellow','label'=>'Menunggu'],'accepted'=>['class'=>'badge-green','label'=>'Diterima'],'rejected'=>['class'=>'badge-red','label'=>'Ditolak']];
                $sc=$statusMap[$app->status->value]??['class'=>'badge-cream','label'=>$app->status->value];
                $profile=$app->mahasiswa->mahasiswaProfile;
            @endphp
            <div class="glass-card" style="padding:1.5rem;">
                {{-- Candidate Header --}}
                <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.25rem;">
                    <div style="width:52px;height:52px;border-radius:14px;background:#CDF22B;display:flex;align-items:center;justify-content:center;font-size:1.25rem;font-weight:800;color:#1E45FB;flex-shrink:0;">
                        {{ strtoupper(substr($app->mahasiswa->name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:.625rem;flex-wrap:wrap;">
                            <a href="{{ route('profiles.show', $app->mahasiswa) }}" style="font-size:.95rem;font-weight:700;color:#0F172A;text-decoration:none;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#0F172A'">{{ $app->mahasiswa->name }}</a>
                            <span class="badge {{ $sc['class'] }}">{{ $sc['label'] }}</span>
                        </div>
                        <div style="font-size:.775rem;color: #475569;margin-top:.2rem;">
                            {{ $profile?->university ?? 'Universitas tidak dicantumkan' }}
                            @if($profile?->major) · {{ $profile->major }} @endif
                        </div>
                    </div>
                </div>

                {{-- Skills --}}
                @if($profile?->skills)
                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(30, 69, 251, 0.5);margin-bottom:.5rem;">Skills</div>
                    <div style="display:flex;flex-wrap:wrap;gap:.375rem;">
                        @foreach(array_slice(array_map('trim', explode(',', $profile->skills)), 0, 5) as $skill)
                        <span style="padding:3px 10px;border-radius:999px;background:rgba(30, 69, 251, 0.06);border:1px solid rgba(30, 69, 251, 0.12);font-size:.7rem;font-weight:500;color:#1E45FB;">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Stats --}}
                <div style="display:flex;gap:1rem;margin-bottom:1.25rem;padding:.875rem;background:rgba(30,69,251,0.04);border:1px solid rgba(30,69,251,0.1);border-radius:12px;">
                    <div style="text-align:center;flex:1;">
                        <div style="font-size:1.1rem;font-weight:800;color:#1E45FB;">{{ $app->mahasiswa->mahasiswaProfile?->missions_completed ?? 0 }}</div>
                        <div style="font-size:.65rem;color:#475569;text-transform:uppercase;letter-spacing:.06em;">Mission</div>
                    </div>
                    <div style="text-align:center;flex:1;border-left:1px solid rgba(30,69,251,0.1);">
                        <div style="font-size:1.1rem;font-weight:800;color:#1E45FB;">{{ $app->mahasiswa->getAverageRating() }}</div>
                        <div style="font-size:.65rem;color:#475569;text-transform:uppercase;letter-spacing:.06em;">Rating</div>
                    </div>
                    <div style="text-align:center;flex:1;border-left:1px solid rgba(30,69,251,0.1);">
                        <div style="font-size:1.1rem;font-weight:800;color:#1E45FB;">{{ $app->mahasiswa->mahasiswaProfile?->total_points ?? 0 }}</div>
                        <div style="font-size:.65rem;color:#475569;text-transform:uppercase;letter-spacing:.06em;">Poin</div>
                    </div>
                </div>

                {{-- Links --}}
                <div style="display:flex;gap:.5rem;margin-bottom:1.25rem;flex-wrap:wrap;">
                    @if($profile?->linkedin_url)
                    <a href="{{ $profile->linkedin_url }}" target="_blank" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">LinkedIn</a>
                    @endif
                    @if($profile?->github_url)
                    <a href="{{ $profile->github_url }}" target="_blank" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">GitHub</a>
                    @endif
                    @if($profile?->portfolio_url)
                    <a href="{{ $profile->portfolio_url }}" target="_blank" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">Portfolio</a>
                    @endif
                </div>

                {{-- Actions --}}
                @if($app->status->value === 'pending')
                <div style="display:flex;gap:.625rem;">
                    <form method="POST" action="{{ route('umkm.applicants.accept', [$mission, $app]) }}" style="flex:1;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            Terima
                        </button>
                    </form>
                    <form method="POST" action="{{ route('umkm.applicants.reject', [$mission, $app]) }}" style="flex:1;" id="reject-form-{{ $app->id }}">
                        @csrf
                        <button type="button" class="btn btn-danger btn-sm" style="width:100%;justify-content:center;" onclick="showConfirm('Tolak lamaran dari {{ $app->mahasiswa->name }}?', { title: 'Tolak Pelamar', okText: 'Ya, Tolak', type: 'danger', icon: '🚫' }).then(ok => { if(ok) document.getElementById('reject-form-{{ $app->id }}').submit(); })">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            Tolak
                        </button>
                    </form>
                </div>
                @elseif($app->status->value === 'accepted')
                <div style="padding:.75rem 1rem;background:rgba(205,242,43,0.08);border:1px solid rgba(205,242,43,0.2);border-radius:12px;text-align:center;font-size:.825rem;font-weight:600;color:#1E45FB;">
                    ✓ Diterima — Sedang Mengerjakan
                </div>
                @else
                <div style="padding:.75rem 1rem;background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.15);border-radius:12px;text-align:center;font-size:.825rem;color:rgba(248,113,113,0.7);">
                    Lamaran Ditolak
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>
