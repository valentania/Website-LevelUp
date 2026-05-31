<x-app-layout>
<div style="padding:2rem 0;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Moderasi Mission</h1>
            <p style="font-size:.875rem;color: #475569;">Review, approve, dan tetapkan kesulitan mission dari UMKM</p>
        </div>
        <div style="display:flex;gap:.625rem;">
            @foreach(['all'=>'Semua','pending'=>'Pending','open'=>'Approved','rejected'=>'Ditolak'] as $val => $lbl)
            <a href="{{ route('admin.missions.index', ['status'=>$val==='all'?'':$val]) }}" class="btn btn-sm {{ (request('status','')===$val || ($val==='all' && !request('status'))) ? 'btn-primary' : 'btn-ghost' }}">{{ $lbl }}</a>
            @endforeach
        </div>
    </div>

    @if($missions->isEmpty())
        <div class="glass-card" style="padding:5rem 2rem;text-align:center;">
            <div class="empty-state-icon" style="margin:0 auto 1.5rem;">✅</div>
            <div class="empty-state-title">Tidak Ada Mission</div>
            <div class="empty-state-desc">Tidak ada mission yang perlu direview saat ini.</div>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:1rem;">
            @foreach($missions as $mission)
            @php
                $statusMap=['open'=>'badge-green','pending'=>'badge-yellow','in_progress'=>'badge-blue','completed'=>'badge-cream','rejected'=>'badge-red','pending_review'=>'badge-yellow'];
                $sc=$statusMap[$mission->status->value]??'badge-cream';
                $cxMap=['easy'=>'complexity-easy','medium'=>'complexity-medium','hard'=>'complexity-hard'];
            @endphp
            <div class="glass-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.625rem;flex-wrap:wrap;">
                            <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">{{ $mission->title }}</h3>
                            <span class="badge {{ $sc }}">{{ $mission->status->label() }}</span>
                            @if($mission->complexity)
                            <span class="badge {{ $cxMap[$mission->complexity->value]??'badge-cream' }}">{{ $mission->complexity->label() }}</span>
                            @endif
                        </div>
                        <div style="display:flex;gap:1.25rem;font-size:.775rem;color: #475569;flex-wrap:wrap;">
                            <span>🏪 {{ $mission->creator->umkmProfile?->business_name ?? $mission->creator->name }}</span>
                            <span>· {{ $mission->category->label() }}</span>
                            @if($mission->deadline)<span>· Deadline {{ $mission->deadline->format('d M Y') }}</span>@endif
                            <span>· Dibuat {{ $mission->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:.625rem;flex-wrap:wrap;flex-shrink:0;">
                        <a href="{{ route('admin.missions.show', $mission) }}" class="btn btn-secondary btn-sm">Review →</a>
                    </div>
                </div>
                @if($mission->rejection_reason)
                <div style="margin-top:.875rem;padding:.75rem 1rem;background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.15);border-radius:10px;font-size:.8rem;color:rgba(248,113,113,0.7);">
                    Alasan ditolak: {{ $mission->rejection_reason }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
        <div style="margin-top:2rem;display:flex;justify-content:center;">{{ $missions->links() }}</div>
    @endif
</div>
</x-app-layout>
