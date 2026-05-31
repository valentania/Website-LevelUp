<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Portfolio</h1>
            <p style="font-size:.875rem;color: #475569;">Showcase project-mu — bukti kontribusi nyata yang kamu banggakan</p>
        </div>
    </div>

    {{-- Stats Row --}}
    @if($portfolios->isNotEmpty())
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;margin-bottom:2rem;">
        <div class="stat-card">
            <div style="font-size:1.5rem;margin-bottom:.625rem;">💼</div>
            <div class="stat-value" style="font-size:1.75rem;">{{ $portfolios->total() }}</div>
            <div class="stat-label">Total Project</div>
        </div>
        <div class="stat-card">
            <div style="font-size:1.5rem;margin-bottom:.625rem;">⭐</div>
            <div class="stat-value" style="font-size:1.75rem;">{{ $portfolios->avg(fn($p) => $p->mission?->review?->rating) ? number_format($portfolios->avg(fn($p) => $p->mission?->review?->rating),1) : '-' }}</div>
            <div class="stat-label">Rata-rata Rating</div>
        </div>
        <div class="stat-card">
            <div style="font-size:1.5rem;margin-bottom:.625rem;">🏪</div>
            <div class="stat-value" style="font-size:1.75rem;">{{ $portfolios->pluck('mission.creator.id')->unique()->count() }}</div>
            <div class="stat-label">UMKM Dilayani</div>
        </div>
    </div>
    @endif

    {{-- Portfolio Grid --}}
    @if($portfolios->isEmpty())
        <div class="glass-card" style="padding:5rem 2rem;text-align:center;">
            <div class="empty-state-icon" style="margin:0 auto 1.5rem;">💼</div>
            <div class="empty-state-title">Portfolio Masih Kosong</div>
            <div class="empty-state-desc">Selesaikan mission untuk otomatis mendapatkan portfolio profesional di sini!</div>
            <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-primary" style="margin-top:1.5rem;">Cari Mission</a>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:2rem;">
            @foreach($portfolios as $portfolio)
            <a href="{{ route('mahasiswa.portfolio.show', $portfolio) }}" style="text-decoration:none;display:flex;align-items:center;gap:1.5rem;padding:1.25rem 1.5rem;background:rgba(248, 250, 252, 0.03);border: 1px solid #475569;border-radius:16px;transition:all .2s;" onmouseover="this.style.background='rgba(248, 250, 252, 0.06)';this.style.borderColor='rgba(205, 242, 43, 0.3)'" onmouseout="this.style.background='rgba(248, 250, 252, 0.03)';this.style.borderColor='rgba(248, 250, 252, 0.08)'">
                
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(205, 242, 43,0.1);display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">
                    {{ $portfolio->mission?->category?->icon() ?? '💼' }}
                </div>
                
                <div style="flex:1;min-width:0;">
                    <h3 style="font-size:1.05rem;font-weight:700;color:#0F172A;margin-bottom:.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $portfolio->title ?? $portfolio->mission?->title }}</h3>
                    <div style="display:flex;align-items:center;gap:1rem;font-size:.8rem;color:rgba(248, 250, 252, 0.5);">
                        <span>🏪 {{ $portfolio->mission?->creator?->umkmProfile?->business_name ?? '-' }}</span>
                        <span>📅 {{ $portfolio->created_at->format('M Y') }}</span>
                    </div>
                </div>

                @if($portfolio->mission?->review)
                <div style="flex-shrink:0;text-align:right;">
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;border-radius:999px;background:rgba(205, 242, 43, 0.1);font-size:.8rem;font-weight:700;color:#CDF22B;">
                        ⭐ {{ $portfolio->mission->review->rating }}.0
                    </span>
                </div>
                @endif
                
                <div style="color: #94A3B8;flex-shrink:0;margin-left:1rem;">→</div>
            </a>
            @endforeach
        </div>

        <div style="display:flex;justify-content:center;">
            {{ $portfolios->links() }}
        </div>
    @endif

</div>
</x-app-layout>
