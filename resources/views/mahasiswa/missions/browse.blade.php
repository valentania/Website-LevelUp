<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Page Header --}}
    <div style="margin-bottom:2rem;">
        <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Cari Mission</h1>
        <p style="font-size:.875rem;color: #475569;">Temukan mission yang sesuai dengan skill dan minat-mu</p>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('mahasiswa.missions.browse') }}" style="margin-bottom:2rem;">
        <div style="background:rgba(0, 0, 0, 0.2);border: 1px solid rgba(248, 250, 252, 0.1);border-radius:20px;padding:1.5rem;display:flex;flex-wrap:wrap;align-items:flex-end;gap:1rem;">
            <div style="flex:1;min-width:220px;">
                <label class="input-label">Cari Mission</label>
                <div style="position:relative;">
                    <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color: #94A3B8;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input name="search" type="text" value="{{ $search ?? '' }}" placeholder="Judul mission, skill..." class="input-field" style="padding-left:2.5rem;">
                </div>
            </div>
            <div style="min-width:160px;">
                <label class="input-label">Kategori</label>
                <select name="category" class="input-field">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->value }}" {{ ($filters['category'] ?? '') === $cat->value ? 'selected' : '' }}>{{ $cat->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:140px;">
                <label class="input-label">Kesulitan</label>
                <select name="complexity" class="input-field">
                    <option value="">Semua Level</option>
                    @foreach($complexities as $c)
                        <option value="{{ $c->value }}" {{ ($filters['complexity'] ?? '') === $c->value ? 'selected' : '' }}>{{ $c->label() }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Cari
            </button>
            @if($search || ($filters['category'] ?? '') || ($filters['complexity'] ?? ''))
            <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-ghost">Reset</a>
            @endif
        </div>
    </form>

    {{-- Results --}}
    @if($missions->isEmpty())
        <div class="glass-card" style="padding:4rem 2rem;text-align:center;">
            <div class="empty-state-icon" style="margin:0 auto 1.5rem;">🔍</div>
            <div class="empty-state-title">Tidak Ada Mission Tersedia</div>
            <div class="empty-state-desc">Coba ubah filter atau kata kunci pencarian, atau cek lagi nanti!</div>
            <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-secondary" style="margin-top:1rem;">Reset Filter</a>
        </div>
    @else
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem;">
            <span style="font-size:.825rem;color: #475569;">Menampilkan {{ $missions->total() }} mission</span>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.25rem;margin-bottom:2rem;">
            @foreach($missions as $mission)
            <div class="mission-card">
                {{-- Top badges --}}
                <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1rem;flex-wrap:wrap;">
                    @php
                        $cxMap = ['easy'=>'complexity-easy','medium'=>'complexity-medium','hard'=>'complexity-hard'];
                        $cxClass = $cxMap[$mission->complexity->value] ?? 'badge-cream';
                    @endphp
                    <span class="badge {{ $cxClass }}" style="border-radius:8px;">{{ $mission->complexity->label() }}</span>
                    <span class="badge badge-cream" style="border-radius:8px;">{{ $mission->category->label() }}</span>
                    <span style="margin-left:auto;font-size:.8rem;font-weight:700;color:#CDF22B;display:flex;align-items:center;gap:4px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#CDF22B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ $mission->points_reward }} pts
                    </span>
                </div>

                {{-- Title & desc --}}
                <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin-bottom:.5rem;line-height:1.4;">{{ $mission->title }}</h3>
                <p style="font-size:.825rem;color: #475569;line-height:1.6;margin-bottom:1rem;">{{ Str::limit($mission->description, 110) }}</p>

                {{-- Meta --}}
                <div style="display:flex;align-items:center;gap:1rem;font-size:.75rem;color:rgba(248, 250, 252, 0.35);margin-bottom:1.25rem;flex-wrap:wrap;">
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                        {{ $mission->creator->umkmProfile?->business_name ?? $mission->creator->name }}
                    </span>
                    @if($mission->deadline)
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        {{ $mission->deadline->format('d M Y') }}
                    </span>
                    @endif
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                        {{ $mission->applications->count() }}/{{ $mission->max_applicants }}
                    </span>
                </div>

                <a href="{{ route('mahasiswa.missions.show', $mission) }}" class="btn btn-primary" style="width:100%;justify-content:center;">
                    Lihat Detail
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div style="display:flex;justify-content:center;">
            {{ $missions->withQueryString()->links() }}
        </div>
    @endif

</div>
</x-app-layout>
