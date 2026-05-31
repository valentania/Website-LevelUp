<x-app-layout>
<div style="padding:2rem 0;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Mission Saya</h1>
            <p style="font-size:.875rem;color: #475569;">Kelola semua mission yang kamu buat</p>
        </div>
        @php $hasActiveMission = $missions->filter(fn($m) => in_array($m->status->value,['open','in_progress','pending_review']))->isNotEmpty(); @endphp
        @if($hasActiveMission)
            <div style="display:flex;align-items:center;gap:.75rem;padding:.625rem 1.125rem;background:rgba(205, 242, 43,0.06);border:1px solid rgba(205, 242, 43,0.2);border-radius:12px;">
                <span style="font-size:.875rem;color: #475569;">Mission aktif sedang berjalan</span>
                <span class="badge badge-yellow">Limit 1</span>
            </div>
        @else
            <a href="{{ route('umkm.missions.create') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Buat Mission Baru
            </a>
        @endif
    </div>

    @if($missions->isEmpty())
        <div class="glass-card" style="padding:5rem 2rem;text-align:center;">
            <div class="empty-state-icon" style="margin:0 auto 1.5rem;">📝</div>
            <div class="empty-state-title">Belum Ada Mission</div>
            <div class="empty-state-desc">Buat mission pertamamu dan dapatkan bantuan dari mahasiswa berbakat!</div>
            <a href="{{ route('umkm.missions.create') }}" class="btn btn-primary" style="margin-top:1.5rem;">Buat Mission Pertama</a>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:1rem;">
            @foreach($missions as $mission)
            @php
                $statusMap=['open'=>['class'=>'badge-green','label'=>'Terbuka'],'pending'=>['class'=>'badge-yellow','label'=>'Menunggu'],'in_progress'=>['class'=>'badge-blue','label'=>'Berjalan'],'completed'=>['class'=>'badge-cream','label'=>'Selesai'],'rejected'=>['class'=>'badge-red','label'=>'Ditolak'],'pending_review'=>['class'=>'badge-yellow','label'=>'Pending Review']];
                $sc=$statusMap[$mission->status->value]??['class'=>'badge-cream','label'=>$mission->status->value];
            @endphp
            <div class="glass-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.625rem;flex-wrap:wrap;">
                            <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">{{ $mission->title }}</h3>
                            <span class="badge {{ $sc['class'] }}">{{ $sc['label'] }}</span>
                            @if($mission->complexity)
                            @php $cxMap=['easy'=>'complexity-easy','medium'=>'complexity-medium','hard'=>'complexity-hard']; @endphp
                            <span class="badge {{ $cxMap[$mission->complexity->value]??'badge-cream' }}">{{ $mission->complexity->label() }}</span>
                            @endif
                        </div>
                        <div style="display:flex;gap:1.25rem;font-size:.775rem;color: #475569;flex-wrap:wrap;">
                            <span>{{ $mission->applications->count() }} pelamar</span>
                            @if($mission->deadline)<span>· Deadline {{ $mission->deadline->format('d M Y') }}</span>@endif
                            <span>· {{ $mission->points_reward }} pts</span>
                            <span>· Dibuat {{ $mission->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:.625rem;flex-wrap:wrap;flex-shrink:0;">
                        <a href="{{ route('umkm.missions.show', $mission) }}" class="btn btn-secondary btn-sm">Detail</a>
                        @if(in_array($mission->status->value,['open','rejected']))
                        <a href="{{ route('umkm.missions.edit', $mission) }}" class="btn btn-ghost btn-sm">Edit</a>
                        @endif
                        @if($mission->status->value === 'open')
                        <a href="{{ route('umkm.missions.applicants', $mission) }}" class="btn btn-primary btn-sm">
                            Pelamar ({{ $mission->applications->count() }})
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
</x-app-layout>
