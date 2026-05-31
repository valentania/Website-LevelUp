<x-app-layout>
<div style="padding:2rem 0;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Lamaran Saya</h1>
            <p style="font-size:.875rem;color: #475569;">Pantau status semua lamaran mission-mu</p>
        </div>
        <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            Cari Mission Baru
        </a>
    </div>

    @if($applications->isEmpty())
        <div class="glass-card" style="padding:5rem 2rem;text-align:center;">
            <div class="empty-state-icon" style="margin:0 auto 1.5rem;">📝</div>
            <div class="empty-state-title">Belum Ada Lamaran</div>
            <div class="empty-state-desc">Kamu belum melamar mission apapun. Mulai cari mission yang sesuai skill-mu!</div>
            <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-primary" style="margin-top:1.5rem;">Cari Mission Sekarang</a>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:1rem;">
            @foreach($applications as $app)
            @php
                $isCompleted = $app->progress && $app->progress->status->value === 'approved';
                $statusMap = ['pending'=>['class'=>'badge-yellow','label'=>'Menunggu'],'accepted'=>['class'=>'badge-green','label'=>'Diterima'],'rejected'=>['class'=>'badge-red','label'=>'Ditolak']];
                $sc = $statusMap[$app->status->value] ?? ['class'=>'badge-cream','label'=>$app->status->value];
                if($isCompleted) $sc = ['class'=>'badge-cream','label'=>'Selesai 🏆'];
            @endphp
            <div class="glass-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.625rem;flex-wrap:wrap;">
                            <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">{{ $app->mission->title }}</h3>
                            <span class="badge {{ $sc['class'] }}">{{ $sc['label'] }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:1.25rem;font-size:.78rem;color: #475569;flex-wrap:wrap;">
                            <span style="display:flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                                <a href="{{ route('profiles.show', $app->mission->creator) }}" style="color: #475569;text-decoration:none;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='rgba(248, 250, 252, 0.4)'">{{ $app->mission->creator->umkmProfile?->business_name ?? $app->mission->creator->name }}</a>
                            </span>
                            <span style="display:flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                Dilamar {{ $app->created_at->diffForHumans() }}
                            </span>
                            @if($app->mission->deadline)
                            <span style="display:flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Deadline {{ $app->mission->deadline->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div style="display:flex;gap:.625rem;flex-wrap:wrap;flex-shrink:0;">
                        @if($app->status->value === 'accepted' && $app->progress)
                            @if($isCompleted && $app->mission->portfolio)
                                <a href="{{ route('mahasiswa.portfolio.show', $app->mission->portfolio) }}" class="btn btn-primary btn-sm">
                                    Lihat Portofolio
                                </a>
                            @else
                                <a href="{{ route('mahasiswa.progress.show', $app->progress) }}" class="btn btn-primary btn-sm">
                                    Buka Workspace →
                                </a>
                            @endif
                        @endif
                        <a href="{{ route('mahasiswa.missions.show', $app->mission) }}" class="btn btn-ghost btn-sm">Lihat Mission</a>
                    </div>
                </div>

                @if($app->status->value === 'accepted' && $app->progress)
                <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid rgba(205, 242, 43,0.08);">
                    @php
                        $progressStatusMap = ['in_progress'=>['label'=>'Sedang Dikerjakan','color'=>'#475569','pct'=>25],'submitted'=>['label'=>'Sudah Dikirim','color'=>'#CDF22B','pct'=>75],'revision_requested'=>['label'=>'Perlu Revisi','color'=>'#fca5a5','pct'=>60],'final_submitted'=>['label'=>'Final Dikirim','color'=>'#a78bfa','pct'=>90],'approved'=>['label'=>'Disetujui','color'=>'#6ee7b7','pct'=>100]];
                        $ps = $progressStatusMap[$app->progress->status->value] ?? ['label'=>$app->progress->status->value,'color'=>'#F8FAFC','pct'=>50];
                    @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.625rem;">
                        <span style="font-size:.78rem;font-weight:600;color:{{ $ps['color'] }};">{{ $ps['label'] }}</span>
                        <span style="font-size:.72rem;color: #475569;">{{ $ps['pct'] }}%</span>
                    </div>
                    <div class="progress-bar-track">
                        <div class="progress-bar-fill" style="width:{{ $ps['pct'] }}%;background:linear-gradient(90deg,{{ $ps['color'] }},{{ $ps['color'] }}99);"></div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif

</div>
</x-app-layout>
