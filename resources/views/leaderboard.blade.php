<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leaderboard — LevelUp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="font-family:'Inter',sans-serif;background:#FFFFFF;">

{{-- Navbar --}}
@include('layouts.navigation')

<div class="page-wrapper">
<div class="page-container">
<div style="padding:2rem 0;">

    {{-- Header --}}
    <div style="text-align:center;margin-bottom:3rem;">
        <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 16px;border-radius:999px;background:rgba(205,242,43,0.2);border:1px solid rgba(205,242,43,0.5);font-size:.78rem;font-weight:700;color:#0F172A;text-transform:uppercase;letter-spacing:.06em;margin-bottom:1.25rem;">
            🏆 Kontributor Terbaik
        </div>
        <h1 style="font-size:clamp(2rem,5vw,3rem);font-weight:900;color:#0F172A;margin-bottom:.75rem;font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:-0.03em;">Leaderboard</h1>
        <p style="font-size:1rem;color:#475569;max-width:500px;margin:0 auto;">Mahasiswa dengan kontribusi sosial digital terbaik di platform LevelUp</p>
    </div>

    {{-- Top 3 Podium --}}
    @if($topMahasiswa->count() >= 3)
    <div style="display:flex;align-items:flex-end;justify-content:center;gap:1rem;margin-bottom:3rem;flex-wrap:wrap;">
        {{-- 2nd Place --}}
        <div style="text-align:center;flex:1;max-width:220px;">
            <div style="width:70px;height:70px;border-radius:50%;background:rgba(30,69,251,0.08);border:2px solid rgba(30,69,251,0.2);display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;color:#1E45FB;margin:0 auto 1rem;">{{ strtoupper(substr($topMahasiswa[1]->name,0,1)) }}</div>
            <div style="background:#F8FAFC;border:1px solid rgba(30,69,251,0.1);border-radius:16px 16px 0 0;padding:1.25rem;height:160px;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;">
                <div style="font-size:1.5rem;margin-bottom:.5rem;">🥈</div>
                <div style="font-size:.9rem;font-weight:700;color:#0F172A;margin-bottom:.25rem;">{{ Str::limit($topMahasiswa[1]->name,18) }}</div>
                <div style="font-size:.75rem;color:#475569;">{{ $topMahasiswa[1]->mahasiswaProfile?->university ?? '' }}</div>
                <div style="font-size:1.2rem;font-weight:800;color:#1E45FB;margin-top:.5rem;">{{ number_format($topMahasiswa[1]->mahasiswaProfile?->total_points ?? 0) }}</div>
                <div style="font-size:.65rem;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;">poin</div>
            </div>
        </div>
        {{-- 1st Place --}}
        <div style="text-align:center;flex:1;max-width:250px;">
            <div style="position:relative;display:inline-block;margin-bottom:1rem;">
                <div style="width:86px;height:86px;border-radius:50%;background:#CDF22B;border:3px solid #CDF22B;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#0F172A;box-shadow:0 0 30px rgba(205,242,43,0.5);">{{ strtoupper(substr($topMahasiswa[0]->name,0,1)) }}</div>
                <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);font-size:1.5rem;">👑</div>
            </div>
            <div style="background:linear-gradient(135deg,#1E45FB,#1338CC);border:1px solid rgba(205,242,43,0.4);border-radius:16px 16px 0 0;padding:1.5rem;height:200px;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;box-shadow:0 8px 30px rgba(30,69,251,0.2);">
                <div style="font-size:1.75rem;margin-bottom:.5rem;">🥇</div>
                <div style="font-size:1rem;font-weight:800;color:#FFFFFF;margin-bottom:.25rem;">{{ Str::limit($topMahasiswa[0]->name,18) }}</div>
                <div style="font-size:.78rem;color:rgba(255,255,255,0.7);">{{ $topMahasiswa[0]->mahasiswaProfile?->university ?? '' }}</div>
                <div style="font-size:1.5rem;font-weight:900;color:#CDF22B;margin-top:.5rem;">{{ number_format($topMahasiswa[0]->mahasiswaProfile?->total_points ?? 0) }}</div>
                <div style="font-size:.65rem;color:rgba(205,242,43,0.7);text-transform:uppercase;letter-spacing:.06em;">poin</div>
            </div>
        </div>
        {{-- 3rd Place --}}
        <div style="text-align:center;flex:1;max-width:220px;">
            <div style="width:70px;height:70px;border-radius:50%;background:rgba(245,158,11,0.1);border:2px solid rgba(245,158,11,0.3);display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;color:#F59E0B;margin:0 auto 1rem;">{{ strtoupper(substr($topMahasiswa[2]->name,0,1)) }}</div>
            <div style="background:#F8FAFC;border:1px solid rgba(245,158,11,0.15);border-radius:16px 16px 0 0;padding:1.25rem;height:130px;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;">
                <div style="font-size:1.5rem;margin-bottom:.5rem;">🥉</div>
                <div style="font-size:.9rem;font-weight:700;color:#0F172A;margin-bottom:.25rem;">{{ Str::limit($topMahasiswa[2]->name,18) }}</div>
                <div style="font-size:.75rem;color:#475569;">{{ $topMahasiswa[2]->mahasiswaProfile?->university ?? '' }}</div>
                <div style="font-size:1.2rem;font-weight:800;color:#F59E0B;margin-top:.5rem;">{{ number_format($topMahasiswa[2]->mahasiswaProfile?->total_points ?? 0) }}</div>
                <div style="font-size:.65rem;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;">poin</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Full Ranking Table --}}
    <div class="glass-card" style="padding:1.75rem;">
        <div class="section-title" style="margin-bottom:1.5rem;">Semua Kontributor</div>
        @if($topMahasiswa->isEmpty())
        <div class="empty-state" style="padding:3rem 1rem;">
            <div class="empty-state-icon" style="margin:0 auto 1rem;">🏆</div>
            <div class="empty-state-title">Belum Ada Kontributor</div>
            <div class="empty-state-desc">Jadilah yang pertama menyelesaikan mission!</div>
        </div>
        @else
        <div style="display:flex;flex-direction:column;gap:.625rem;">
            @foreach($topMahasiswa as $i => $mahasiswa)
            @php $rank = $i + 1; @endphp
            <div style="display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;background:{{ $rank<=3 ? '#F8FAFC' : '#FFFFFF' }};border:1px solid {{ $rank===1 ? 'rgba(205,242,43,0.5)' : ($rank<=3 ? 'rgba(30,69,251,0.1)' : 'rgba(30,69,251,0.06)') }};border-radius:14px;transition:all .2s;" onmouseover="this.style.borderColor='rgba(30,69,251,0.2)';this.style.background='#F8FAFC'" onmouseout="this.style.borderColor='{{ $rank===1 ? 'rgba(205,242,43,0.5)' : ($rank<=3 ? 'rgba(30,69,251,0.1)' : 'rgba(30,69,251,0.06)') }}';this.style.background='{{ $rank<=3 ? '#F8FAFC' : '#FFFFFF' }}'">
                {{-- Rank --}}
                <div style="width:36px;height:36px;border-radius:10px;{{ $rank===1 ? 'background:#CDF22B;color:#0F172A;' : 'background:#F1F5F9;color:#475569;border:1px solid rgba(30,69,251,0.08);' }}display:flex;align-items:center;justify-content:center;font-size:.875rem;font-weight:800;flex-shrink:0;">
                    {{ $rank<=3 ? ['🥇','🥈','🥉'][$rank-1] : '#'.$rank }}
                </div>
                {{-- Avatar --}}
                <div style="width:40px;height:40px;border-radius:12px;background:{{ $rank===1 ? '#1E45FB' : 'rgba(30,69,251,0.08)' }};display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;color:{{ $rank===1 ? '#FFFFFF' : '#1E45FB' }};flex-shrink:0;">
                    {{ strtoupper(substr($mahasiswa->name, 0, 1)) }}
                </div>
                {{-- Info --}}
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.9rem;font-weight:700;color:#0F172A;">{{ $mahasiswa->name }}</div>
                    <div style="font-size:.75rem;color:#475569;">{{ $mahasiswa->mahasiswaProfile?->university ?? 'Universitas' }} @if($mahasiswa->mahasiswaProfile?->major)· {{ $mahasiswa->mahasiswaProfile->major }}@endif</div>
                </div>
                {{-- Stats --}}
                <div style="display:flex;gap:1.5rem;flex-shrink:0;flex-wrap:wrap;">
                    <div style="text-align:center;">
                        <div style="font-size:1rem;font-weight:800;color:#1E45FB;">{{ number_format($mahasiswa->mahasiswaProfile?->total_points ?? 0) }}</div>
                        <div style="font-size:.65rem;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;">Poin</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:1rem;font-weight:800;color:#0F172A;">{{ $mahasiswa->mahasiswaProfile?->missions_completed ?? 0 }}</div>
                        <div style="font-size:.65rem;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;">Mission</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:1rem;font-weight:800;color:#0F172A;">{{ $mahasiswa->badges->count() }}</div>
                        <div style="font-size:.65rem;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;">Badge</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
</div>
</div>
</body>
</html>
