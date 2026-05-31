<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ route('admin.missions.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Moderasi
    </a>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Mission Info --}}
            <div class="glass-card" style="padding:2rem;">
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
                    @php
                        $statusMap=['open'=>'badge-green','pending'=>'badge-yellow','in_progress'=>'badge-blue','completed'=>'badge-cream','rejected'=>'badge-red','pending_review'=>'badge-yellow'];
                        $sc=$statusMap[$mission->status->value]??'badge-cream';
                        $cxMap=['easy'=>'complexity-easy','medium'=>'complexity-medium','hard'=>'complexity-hard'];
                    @endphp
                    <span class="badge {{ $sc }}">{{ $mission->status->label() }}</span>
                    <span class="badge badge-cream">{{ $mission->category->label() }}</span>
                    @if($mission->complexity)
                    <span class="badge {{ $cxMap[$mission->complexity->value]??'badge-cream' }}">{{ $mission->complexity->label() }}</span>
                    @endif
                </div>

                <h1 style="font-size:1.5rem;font-weight:800;color:#0F172A;margin-bottom:1rem;">{{ $mission->title }}</h1>

                <div class="divider"></div>

                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;margin-bottom:.625rem;">Deskripsi</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->description }}</p>
                </div>

                @if($mission->requirements)
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;margin-bottom:.625rem;">Persyaratan</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->requirements }}</p>
                </div>
                @endif

                @if($mission->deliverables)
                <div>
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;margin-bottom:.625rem;">Hasil yang Diharapkan</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->deliverables }}</p>
                </div>
                @endif
            </div>

            {{-- Admin Actions --}}
            @if($mission->status->value === 'pending_review')
            <div class="glass-card" style="padding:2rem;" x-data="{ showReject: false }">
                <div class="section-title" style="margin-bottom:1.5rem;">⚙️ Tindakan Admin</div>

                {{-- Set Difficulty --}}
                <div style="margin-bottom:1.5rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;margin-bottom:.875rem;">Validasi Tingkat Kesulitan</div>

                    {{-- UMKM Suggestion --}}
                    @if($mission->complexity)
                    <div style="display:flex;align-items:center;gap:.625rem;padding:.75rem 1rem;background:rgba(205,242,43,0.08);border:1px solid rgba(205,242,43,0.25);border-radius:10px;margin-bottom:1rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#CDF22B" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        <span style="font-size:.8rem;color:#0F172A;">Saran UMKM: <strong>{{ $mission->complexity->label() }}</strong> — Admin dapat mengubahnya.</span>
                    </div>
                    @else
                    <div style="display:flex;align-items:center;gap:.625rem;padding:.75rem 1rem;background:#F8FAFC;border:1px solid rgba(30,69,251,0.08);border-radius:10px;margin-bottom:1rem;">
                        <span style="font-size:.8rem;color:#475569;">UMKM tidak memberikan saran tingkat kesulitan. Tentukan di bawah ini.</span>
                    </div>
                    @endif

                    <div style="display:flex;gap:.75rem;flex-wrap:wrap;" id="difficulty-selector">
                        @foreach(['easy'=>['label'=>'Mudah','emoji'=>'🟢','color'=>'#22c55e','bg'=>'rgba(34,197,94,0.08)','border'=>'rgba(34,197,94,0.25)'],
                                  'medium'=>['label'=>'Menengah','emoji'=>'🟡','color'=>'#F59E0B','bg'=>'rgba(245,158,11,0.08)','border'=>'rgba(245,158,11,0.25)'],
                                  'hard'=>['label'=>'Sulit','emoji'=>'🔴','color'=>'#EF4444','bg'=>'rgba(239,68,68,0.08)','border'=>'rgba(239,68,68,0.25)']] as $val => $cfg)
                        <label style="cursor:pointer;">
                            <input type="radio" name="selected_complexity" value="{{ $val }}" style="display:none;" {{ $mission->complexity?->value === $val ? 'checked' : '' }}>
                            <div id="diff-{{ $val }}" style="padding:.875rem 1.75rem;border-radius:12px;border:2px solid {{ $cfg['border'] }};background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};font-size:.875rem;font-weight:700;cursor:pointer;transition:all .2s;opacity:{{ $mission->complexity?->value === $val ? '1' : '.5' }};" onclick="document.querySelector('[name=selected_complexity][value={{ $val }}]').checked=true;selectDifficulty('{{ $val }}')">
                                {{ $cfg['emoji'] }} {{ $cfg['label'] }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div style="display:flex;gap:.875rem;flex-wrap:wrap;">
                    <form method="POST" action="{{ route('admin.missions.approve', $mission) }}" id="approve-form">
                        @csrf
                        <input type="hidden" name="complexity" id="complexity-input" value="">
                        <button type="submit" class="btn btn-primary" onclick="return submitApprove()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            Approve Mission
                        </button>
                    </form>

                    <button type="button" @click="showReject = !showReject" class="btn btn-danger">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        Tolak Mission
                    </button>
                </div>

                <div x-show="showReject" x-cloak style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid rgba(248, 250, 252,0.08);">
                    <form method="POST" action="{{ route('admin.missions.reject', $mission) }}" id="reject-mission-form">
                        @csrf
                        <label class="input-label">Alasan Penolakan *</label>
                        <textarea name="rejection_reason" rows="3" class="input-field" placeholder="Jelaskan mengapa mission ini ditolak..." required style="margin-bottom:.875rem;"></textarea>
                        <button type="button" class="btn btn-danger" onclick="showConfirm('Tolak mission ini? Tindakan ini tidak dapat dibatalkan.', { title: 'Tolak Mission', okText: 'Ya, Tolak', type: 'danger', icon: '🚫' }).then(ok => { if(ok) document.getElementById('reject-mission-form').submit(); })">Konfirmasi Penolakan</button>
                    </form>
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:90px;">
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Info Mission</div>
                @php $infos=[
                    ['label'=>'UMKM','value'=>$mission->creator->umkmProfile?->business_name??$mission->creator->name],
                    ['label'=>'Deadline','value'=>$mission->deadline?->format('d M Y')??'-'],
                    ['label'=>'Maks. Pelamar','value'=>$mission->max_applicants],
                    ['label'=>'Pelamar','value'=>$mission->applications->count()],
                    ['label'=>'Dibuat','value'=>$mission->created_at->format('d M Y')],
                ]; @endphp
                @foreach($infos as $info)
                <div style="padding:.625rem 0;border-bottom:1px solid rgba(248, 250, 252,0.06);display:flex;justify-content:space-between;">
                    <dt style="font-size:.78rem;color: #475569;">{{ $info['label'] }}</dt>
                    <dd style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $info['value'] }}</dd>
                </div>
                @endforeach
            </div>

            @if($mission->rejection_reason)
            <div style="background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.2);border-radius:16px;padding:1.25rem;">
                <div style="font-size:.72rem;font-weight:700;color:#fca5a5;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">Alasan Ditolak</div>
                <p style="font-size:.825rem;color: #475569;">{{ $mission->rejection_reason }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
let selectedDifficulty = null;
function selectDifficulty(val) {
    selectedDifficulty = val;
    ['easy','medium','hard'].forEach(d => {
        const el = document.getElementById('diff-'+d);
        el.style.opacity = d === val ? '1' : '.4';
        el.style.transform = d === val ? 'scale(1.03)' : 'scale(1)';
    });
}
function submitApprove() {
    if (!selectedDifficulty) {
        alert('Silakan pilih tingkat kesulitan terlebih dahulu!');
        return false;
    }
    document.getElementById('complexity-input').value = selectedDifficulty;
    return true;
}
</script>
</x-app-layout>
