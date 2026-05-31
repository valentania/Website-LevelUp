<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,rgba(30,69,251,0.06),rgba(30,69,251,0.02));border:1px solid rgba(30,69,251,0.1);border-radius:24px;padding:2rem 2.5rem;margin-bottom:2rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(30,69,251,0.06),transparent);pointer-events:none;"></div>
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;position:relative;z-index:1;">
            <div>
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.5rem;">
                    <div style="width:48px;height:48px;border-radius:14px;background:rgba(30,69,251,0.08);border:1px solid rgba(30,69,251,0.15);display:flex;align-items:center;justify-content:center;font-size:1.5rem;">🛡️</div>
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;">Admin Panel</div>
                        <h1 style="font-size:1.4rem;font-weight:800;color:#0F172A;margin:0;font-family:'Plus Jakarta Sans',sans-serif;">Control Center</h1>
                    </div>
                </div>
                <p style="font-size:.875rem;color:#475569;margin:0;">Kelola platform LevelUp — review mission, pantau pengguna, dan monitor dampak sosial.</p>
            </div>
            <div style="display:flex;gap:.75rem;">
                <a href="{{ route('admin.missions.index') }}" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    Review Mission
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kelola Users</a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="font-size:1.5rem;">👥</div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(30,69,251,0.08);font-size:.7rem;font-weight:700;color:#1E45FB;text-transform:uppercase;">Users</div>
            </div>
            <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
            <div class="stat-label">Total Pengguna</div>
            <div style="font-size:.72rem;color:#94A3B8;margin-top:.5rem;">🎓 {{ $stats['total_mahasiswa'] ?? 0 }} Mahasiswa · 🏪 {{ $stats['total_umkm'] ?? 0 }} UMKM</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="font-size:1.5rem;">📋</div>
                <div style="padding:4px 10px;border-radius:999px;background:#F1F5F9;font-size:.7rem;font-weight:700;color:#475569;text-transform:uppercase;">Missions</div>
            </div>
            <div class="stat-value">{{ $stats['total_missions'] ?? 0 }}</div>
            <div class="stat-label">Total Mission</div>
            <div style="font-size:.72rem;color:#94A3B8;margin-top:.5rem;">✅ {{ $stats['completed_missions'] ?? 0 }} Selesai · ⚡ {{ $stats['active_missions'] ?? 0 }} Aktif</div>
        </div>
        <div class="stat-card" style="border-color:rgba(205,242,43,0.4);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="font-size:1.5rem;">⏳</div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(205,242,43,0.2);font-size:.7rem;font-weight:700;color:#0F172A;text-transform:uppercase;">Pending</div>
            </div>
            <div class="stat-value" style="color:{{ ($stats['pending_missions'] ?? 0) > 0 ? '#1E45FB' : '' }}">{{ $stats['pending_missions'] ?? 0 }}</div>
            <div class="stat-label">Menunggu Validasi</div>
            <div style="font-size:.72rem;color:#475569;margin-top:.5rem;">Perlu review segera</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="font-size:1.5rem;">⭐</div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(205,242,43,0.15);font-size:.7rem;font-weight:700;color:#0F172A;text-transform:uppercase;">Quality</div>
            </div>
            <div class="stat-value">{{ $stats['average_rating'] ?? '0.0' }}</div>
            <div class="stat-label">Rata-rata Rating</div>
            <div style="font-size:.72rem;color:#94A3B8;margin-top:.5rem;">{{ $stats['total_points_distributed'] ?? 0 }} poin terdistribusi</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

        {{-- Social Impact --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div class="section-title" style="margin-bottom:1.5rem;">Dampak Sosial Platform</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                @php $impact_data = [
                    ['icon'=>'🏪','value'=>$impact['umkm_helped']??0,'label'=>'UMKM Terbantu','color'=>'#1E45FB'],
                    ['icon'=>'🎓','value'=>$impact['mahasiswa_active']??0,'label'=>'Mahasiswa Aktif','color'=>'#1E45FB'],
                    ['icon'=>'🤝','value'=>$impact['total_contributions']??0,'label'=>'Kontribusi','color'=>'#0F172A'],
                    ['icon'=>'💬','value'=>$impact['total_reviews']??0,'label'=>'Review','color'=>'#1E45FB'],
                ]; @endphp
                @foreach($impact_data as $item)
                <div style="padding:1.25rem;background:#F8FAFC;border-radius:14px;border:1px solid rgba(30,69,251,0.06);text-align:center;transition:all .2s;" onmouseover="this.style.borderColor='rgba(30,69,251,0.15)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)'">
                    <div style="font-size:1.5rem;margin-bottom:.5rem;">{{ $item['icon'] }}</div>
                    <div style="font-size:1.5rem;font-weight:800;color:{{ $item['color'] }};">{{ $item['value'] }}</div>
                    <div style="font-size:.72rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.06em;margin-top:.25rem;">{{ $item['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Pending Missions --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                <div class="section-title">Mission Pending</div>
                <a href="{{ route('admin.missions.index') }}" style="font-size:.8rem;color:#1E45FB;text-decoration:none;font-weight:600;" onmouseover="this.style.color='#0F172A'" onmouseout="this.style.color='#1E45FB'">Lihat Semua →</a>
            </div>
            @if($pendingMissions->isEmpty())
                <div class="empty-state" style="padding:2.5rem 1rem;">
                    <div class="empty-state-icon" style="font-size:1.5rem;">✅</div>
                    <div class="empty-state-title" style="font-size:1rem;">Semua Bersih!</div>
                    <div class="empty-state-desc">Tidak ada mission yang menunggu review saat ini.</div>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:.75rem;">
                    @foreach($pendingMissions->take(5) as $mission)
                    <a href="{{ route('admin.missions.show', $mission) }}" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.875rem 1.125rem;background:#F8FAFC;border:1px solid rgba(30,69,251,0.06);border-radius:14px;transition:all .2s;text-decoration:none;" onmouseover="this.style.borderColor='#1E45FB';this.style.background='rgba(30,69,251,0.02)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)';this.style.background='#F8FAFC'">
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.875rem;font-weight:600;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $mission->title }}</div>
                            <div style="font-size:.72rem;color:#475569;margin-top:.2rem;">oleh {{ $mission->creator->name }}</div>
                        </div>
                        <span class="badge badge-yellow">Pending</span>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Quick Actions --}}
    <div class="glass-card" style="padding:1.5rem;margin-top:1.5rem;">
        <div class="section-title" style="margin-bottom:1.25rem;">Aksi Cepat</div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:.75rem;">
            @php $actions = [
                ['href'=>route('admin.missions.index'),'icon'=>'🔍','label'=>'Review Mission','desc'=>'Validasi mission baru'],
                ['href'=>route('admin.users.index'),'icon'=>'👥','label'=>'Kelola Users','desc'=>'Pantau pengguna platform'],
                ['href'=>'/leaderboard','icon'=>'🏆','label'=>'Leaderboard','desc'=>'Lihat ranking mahasiswa'],
            ]; @endphp
            @foreach($actions as $action)
            <a href="{{ $action['href'] }}" style="display:flex;align-items:center;gap:.875rem;padding:1rem 1.25rem;background:#F8FAFC;border:1px solid rgba(30,69,251,0.06);border-radius:14px;transition:all .2s;text-decoration:none;" onmouseover="this.style.borderColor='#1E45FB';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)';this.style.transform='translateY(0)'">
                <div style="font-size:1.5rem;">{{ $action['icon'] }}</div>
                <div>
                    <div style="font-size:.875rem;font-weight:600;color:#0F172A;">{{ $action['label'] }}</div>
                    <div style="font-size:.72rem;color:#475569;">{{ $action['desc'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

</div>
</x-app-layout>
