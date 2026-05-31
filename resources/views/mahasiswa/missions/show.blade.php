<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Back button --}}
    <a href="{{ route('mahasiswa.missions.browse') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Mission
    </a>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">

        {{-- Main Content --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Mission Header Card --}}
            <div class="glass-card" style="padding:2rem;">
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
                    @php
                        $cxMap = ['easy'=>'complexity-easy','medium'=>'complexity-medium','hard'=>'complexity-hard'];
                        $cxClass = $cxMap[$mission->complexity->value] ?? 'badge-cream';
                    @endphp
                    <span class="badge {{ $cxClass }}">{{ $mission->complexity->label() }}</span>
                    <span class="badge badge-cream">{{ $mission->category->label() }}</span>
                    <span style="margin-left:auto;font-size:.9rem;font-weight:800;color:#CDF22B;display:flex;align-items:center;gap:5px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#CDF22B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ $mission->points_reward }} pts
                    </span>
                </div>

                <h1 style="font-size:1.5rem;font-weight:800;color:#0F172A;margin-bottom:1rem;line-height:1.35;">{{ $mission->title }}</h1>

                <div class="divider"></div>

                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Deskripsi</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->description }}</p>
                </div>

                @if($mission->requirements)
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Persyaratan</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->requirements }}</p>
                </div>
                @endif

                @if($mission->deliverables)
                <div>
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Hasil yang Diharapkan</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->deliverables }}</p>
                </div>
                @endif
            </div>

            {{-- Apply / Status Section --}}
            @if($hasApplied)
                @php 
                    $app = auth()->user()->missionApplications()->where('mission_id',$mission->id)->first(); 
                    $isCompleted = $app && $app->progress && $app->progress->status->value === 'approved';
                @endphp
                <div style="background:rgba(205, 242, 43,0.06);border:1px solid rgba(205, 242, 43,0.2);border-radius:20px;padding:2rem;text-align:center;">
                    <div style="width:60px;height:60px;border-radius:18px;background:rgba(205, 242, 43,0.12);border:1px solid rgba(205, 242, 43,0.25);display:flex;align-items:center;justify-content:center;font-size:1.75rem;margin:0 auto 1rem;">
                        @if($isCompleted) 🏆 @elseif($app && $app->status->value === 'accepted') ✅ @elseif($app && $app->status->value === 'rejected') ❌ @else ⏳ @endif
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;color:#0F172A;margin-bottom:.5rem;">
                        @if($isCompleted) Mission Selesai!
                        @elseif($app && $app->status->value === 'accepted') Lamaran Diterima!
                        @elseif($app && $app->status->value === 'rejected') Lamaran Tidak Diterima
                        @else Lamaran Terkirim
                        @endif
                    </h3>
                    <p style="font-size:.875rem;color: #475569;margin-bottom:1.25rem;">
                        @if($isCompleted) Selamat! Project ini telah disetujui UMKM. Poin dan portofolio telah ditambahkan ke profilmu.
                        @elseif($app && $app->status->value === 'accepted') Selamat! Kamu diterima. Segera mulai kerjakan mission ini.
                        @elseif($app && $app->status->value === 'rejected') Sayang sekali. Terus coba mission lain!
                        @else Lamaranmu sedang direview oleh UMKM.
                        @endif
                    </p>
                    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
                        @if($isCompleted && $mission->portfolio)
                            <a href="{{ route('mahasiswa.portfolio.show', $mission->portfolio) }}" class="btn btn-primary btn-sm">Lihat Portofolio</a>
                        @else
                            <a href="{{ route('mahasiswa.applications.index') }}" class="btn btn-secondary btn-sm">Lihat Lamaran Saya</a>
                            @if($app && $app->status->value === 'accepted' && $app->progress)
                            <a href="{{ route('mahasiswa.progress.show', $app->progress) }}" class="btn btn-primary btn-sm">Buka Workspace →</a>
                            @endif
                        @endif
                    </div>
                </div>
            @elseif($mission->status->value === 'open')
                {{-- Quick Apply --}}
                <div class="glass-card" style="padding:2rem;">
                    <h3 style="font-size:1.1rem;font-weight:700;color:#0F172A;margin-bottom:.375rem;">Lamar Mission Ini</h3>
                    <p style="font-size:.825rem;color: #475569;margin-bottom:1.5rem;">Kirim lamaran ke UMKM. Lamaran yang kuat meningkatkan peluang diterimamu.</p>
                    <form method="POST" action="{{ route('mahasiswa.applications.store') }}">
                        @csrf
                        <input type="hidden" name="mission_id" value="{{ $mission->id }}">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            Kirim Lamaran
                        </button>
                    </form>
                </div>
            @else
                <div style="background: #F8FAFC;border: 1px solid #475569;border-radius:16px;padding:1.5rem;text-align:center;">
                    <p style="font-size:.875rem;color: #475569;">Mission ini sudah tidak menerima lamaran.</p>
                </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:90px;">

            {{-- Mission Info --}}
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Info Mission</div>
                <dl style="display:flex;flex-direction:column;gap:.875rem;">
                    @php $infos = [
                        ['label'=>'Deadline','value'=>$mission->deadline?->format('d M Y') ?? 'Tidak ada'],
                        ['label'=>'Pelamar','value'=>$mission->applications->count().' / '.$mission->max_applicants],
                        ['label'=>'Poin Reward','value'=>$mission->points_reward.' pts'],
                        ['label'=>'Status','value'=>$mission->status->label()],
                    ]; @endphp
                    @foreach($infos as $info)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:.625rem 0;border-bottom:1px solid rgba(248, 250, 252,0.06);">
                        <dt style="font-size:.78rem;font-weight:500;color: #475569;">{{ $info['label'] }}</dt>
                        <dd style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $info['value'] }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            {{-- UMKM Info --}}
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Pembuat Mission</div>
                <div style="display:flex;align-items:center;gap:.875rem;margin-bottom:1rem;">
                    <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,rgba(205,242,43,0.2),rgba(16,185,129,0.1));border:1px solid rgba(205,242,43,0.2);display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;">🏪</div>
                    <div>
                        <a href="{{ route('profiles.show', $mission->creator) }}" style="font-size:.9rem;font-weight:700;color:#0F172A;text-decoration:none;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#F8FAFC'">{{ $mission->creator->umkmProfile?->business_name ?? $mission->creator->name }}</a>
                        <div style="font-size:.75rem;color: #475569;">{{ $mission->creator->umkmProfile?->business_type ?? 'UMKM' }}</div>
                    </div>
                </div>
                @if($mission->creator->umkmProfile?->city)
                <div style="display:flex;align-items:center;gap:.5rem;font-size:.78rem;color: #475569;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $mission->creator->umkmProfile->city }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@media(max-width:1024px){
    .mission-detail-grid { grid-template-columns: 1fr !important; }
}
</x-app-layout>
