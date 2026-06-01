<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Welcome Hero --}}
    <div style="background:linear-gradient(135deg,rgba(30,69,251,0.05),rgba(205,242,43,0.05));border:1px solid rgba(30,69,251,0.1);border-radius:24px;padding:2rem 2.5rem;margin-bottom:2rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(205,242,43,0.08),transparent);pointer-events:none;"></div>
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;position:relative;z-index:1;">
            <div>
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.5rem;">
                    <div style="width:48px;height:48px;border-radius:14px;background:rgba(30,69,251,0.08);border:1px solid rgba(30,69,251,0.15);display:flex;align-items:center;justify-content:center;color:#1E45FB;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path><path d="M2 7h20"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;">Dashboard UMKM</div>
                        <h1 style="font-size:1.4rem;font-weight:800;color:#0F172A;margin:0;font-family:'Plus Jakarta Sans',sans-serif;">{{ $user->umkmProfile?->business_name ?? $user->name }}</h1>
                    </div>
                </div>
                <p style="font-size:.875rem;color:#475569;margin:0;">Buat mission bantuan digital dan dapatkan bantuan dari mahasiswa terampil Indonesia.</p>
            </div>
            <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                @php $hasActive = $missions->whereIn('status.value', ['open','in_progress','pending_review'])->count() > 0; @endphp
                <a href="{{ route('umkm.missions.create') }}" class="btn {{ $hasActive ? 'btn-ghost' : 'btn-primary' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Buat Mission
                </a>
                <a href="{{ route('umkm.missions.index') }}" class="btn btn-secondary">Lihat Semua Mission</a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(30,69,251,0.08);display:flex;align-items:center;justify-content:center;color:#1E45FB;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M9 9h6"></path><path d="M9 13h6"></path><path d="M9 17h6"></path></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(205,242,43,0.2);font-size:.7rem;font-weight:700;color:#0F172A;text-transform:uppercase;">Total</div>
            </div>
            <div class="stat-value">{{ $user->umkmProfile?->missions_posted ?? 0 }}</div>
            <div class="stat-label">Mission Diposting</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(34,197,94,0.08);display:flex;align-items:center;justify-content:center;color:#22C55E;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(30,69,251,0.08);font-size:.7rem;font-weight:700;color:#1E45FB;text-transform:uppercase;">Aktif</div>
            </div>
            <div class="stat-value">{{ $missions->filter(fn($m) => $m->status->value === 'in_progress')->count() }}</div>
            <div class="stat-label">Sedang Berjalan</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(234,179,8,0.08);display:flex;align-items:center;justify-content:center;color:#EAB308;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(205,242,43,0.15);font-size:.7rem;font-weight:700;color:#0F172A;text-transform:uppercase;">Done</div>
            </div>
            <div class="stat-value">{{ $missions->filter(fn($m) => $m->status->value === 'completed')->count() }}</div>
            <div class="stat-label">Mission Selesai</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(148,163,184,0.08);display:flex;align-items:center;justify-content:center;color:#64748B;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"></path><path d="M5 2h14"></path><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"></path><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"></path></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:#F1F5F9;font-size:.7rem;font-weight:700;color:#475569;text-transform:uppercase;">Review</div>
            </div>
            <div class="stat-value">{{ $missions->filter(fn($m) => $m->status->value === 'pending_review')->count() }}</div>
            <div class="stat-label">Menunggu Review</div>
        </div>
    </div>

    {{-- Active Mission Limit Notice --}}
    @php
        $activeMissions = $missions->filter(fn($m) => in_array($m->status->value, ['open','in_progress','pending_review']));
    @endphp
    @if($activeMissions->isNotEmpty())
    <div style="background:rgba(205,242,43,0.1);border:1px solid rgba(205,242,43,0.4);border-radius:16px;padding:1.25rem 1.5rem;margin-bottom:2rem;display:flex;align-items:center;gap:1rem;">
        <div style="width:40px;height:40px;border-radius:12px;background:rgba(30,69,251,0.08);border:1px solid rgba(30,69,251,0.15);display:flex;align-items:center;justify-content:center;color:#1E45FB;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
        </div>
        <div style="flex:1;">
            <div style="font-size:.875rem;font-weight:700;color:#0F172A;margin-bottom:.2rem;">Mission Aktif Sedang Berjalan</div>
            <div style="font-size:.8rem;color:#475569;">Anda memiliki mission aktif: <strong style="color:#0F172A;">{{ $activeMissions->first()->title }}</strong>. Selesaikan atau tunggu deadline sebelum membuat mission baru.</div>
        </div>
        <a href="{{ route('umkm.missions.show', $activeMissions->first()) }}" class="btn btn-secondary btn-sm" style="flex-shrink:0;">Lihat Mission</a>
    </div>
    @endif

    {{-- Missions List --}}
    <div class="glass-card" style="padding:1.75rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem;">
            <div class="section-title">Mission Terbaru</div>
            <a href="{{ route('umkm.missions.index') }}" style="font-size:.8rem;color:#1E45FB;text-decoration:none;font-weight:600;transition:color .2s;" onmouseover="this.style.color='#0F172A'" onmouseout="this.style.color='#1E45FB'">Lihat Semua →</a>
        </div>

        @if($missions->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon" style="color:#94A3B8;margin-bottom:1rem;display:flex;justify-content:center;">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path></svg>
                </div>
                <div class="empty-state-title">Belum Ada Mission</div>
                <div class="empty-state-desc">Buat mission pertamamu untuk mendapatkan bantuan digital dari mahasiswa!</div>
                <a href="{{ route('umkm.missions.create') }}" class="btn btn-primary">Buat Mission Pertama</a>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:.75rem;">
                @foreach($missions->take(5) as $mission)
                <a href="{{ route('umkm.missions.show', $mission) }}" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.25rem;background:#F8FAFC;border:1px solid rgba(30,69,251,0.06);border-radius:14px;transition:all .2s;text-decoration:none;flex-wrap:wrap;" onmouseover="this.style.borderColor='#1E45FB';this.style.background='rgba(30,69,251,0.02)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)';this.style.background='#F8FAFC'">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.9rem;font-weight:600;color:#0F172A;margin-bottom:.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $mission->title }}</div>
                        <div style="display:flex;align-items:center;gap:.75rem;font-size:.75rem;color:#475569;">
                            <span>{{ $mission->applications->count() }} pelamar</span>
                            @if($mission->deadline)
                            <span>· Deadline {{ $mission->deadline->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                    @php
                        $statusMap = ['open'=>'badge-blue','pending'=>'badge-yellow','in_progress'=>'badge-blue','completed'=>'badge-yellow','rejected'=>'badge-red','pending_review'=>'badge-yellow'];
                        $sc = $statusMap[$mission->status->value] ?? 'badge-cream';
                    @endphp
                    <span class="badge {{ $sc }}">{{ $mission->status->label() }}</span>
                </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
</x-app-layout>
