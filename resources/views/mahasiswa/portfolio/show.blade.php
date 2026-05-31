<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ route('mahasiswa.portfolio.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Portfolio
    </a>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Hero Card --}}
            <div class="glass-card" style="overflow:hidden;">
                <div style="height:200px;background:linear-gradient(135deg,#F1F5F9,#0F172A);position:relative;display:flex;align-items:center;justify-content:center;">
                    <div style="width:80px;height:80px;border-radius:24px;background:rgba(205, 242, 43,0.1);border:1px solid rgba(205, 242, 43,0.2);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                        {{ $portfolio->mission?->category?->icon() ?? '💼' }}
                    </div>
                    <div style="position:absolute;bottom:1rem;right:1rem;display:flex;gap:.5rem;">
                        @if($portfolio->project_url)
                        <a href="{{ $portfolio->project_url }}" target="_blank" class="btn btn-secondary btn-sm">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Live Project
                        </a>
                        @endif
                    </div>
                </div>

                <div style="padding:2rem;">
                    <h1 style="font-size:1.5rem;font-weight:800;color:#0F172A;margin-bottom:.75rem;">{{ $portfolio->title ?? $portfolio->mission?->title }}</h1>

                    @if($portfolio->skills_used)
                    <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.25rem;">
                        @foreach(is_array($portfolio->skills_used) ? $portfolio->skills_used : explode(',', $portfolio->skills_used) as $skill)
                        <span style="padding:4px 12px;border-radius:999px;background:rgba(205, 242, 43,0.08);border:1px solid rgba(205, 242, 43,0.2);font-size:.78rem;font-weight:600;color:#CDF22B;">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div class="divider"></div>

                    <div style="margin-bottom:1.25rem;">
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Deskripsi Project</div>
                        <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $portfolio->description ?? $portfolio->mission?->description }}</p>
                    </div>

                    @if($portfolio->mission?->progress?->progress_note)
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Hasil yang Dicapai</div>
                        <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $portfolio->mission->progress->progress_note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Review --}}
            @if($portfolio->mission?->review)
            <div class="glass-card" style="padding:1.75rem;">
                <div class="section-title" style="margin-bottom:1.25rem;">Review dari UMKM</div>
                <div style="display:flex;align-items:center;gap:.875rem;margin-bottom:1rem;">
                    <div style="width:44px;height:44px;border-radius:12px;background:rgba(205, 242, 43,0.1);border:1px solid rgba(205, 242, 43,0.2);display:flex;align-items:center;justify-content:center;font-size:1.25rem;">🏪</div>
                    <div>
                        <div style="font-size:.9rem;font-weight:600;color:#0F172A;">{{ $portfolio->mission->creator->umkmProfile?->business_name ?? $portfolio->mission->creator->name }}</div>
                        <div style="display:flex;gap:2px;margin-top:3px;">
                            @for($i = 1; $i <= 5; $i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $portfolio->mission->review->rating ? '#CDF22B' : 'rgba(205, 242, 43,0.2)' }}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <p style="font-size:.9rem;color: #475569;line-height:1.7;font-style:italic;">"{{ $portfolio->mission->review->comment }}"</p>
                @if($portfolio->mission->review->strengths)
                <div style="margin-top:1rem;padding:.875rem 1rem;background:rgba(205,242,43,0.06);border:1px solid rgba(205,242,43,0.15);border-radius:12px;">
                    <div style="font-size:.72rem;font-weight:700;color:#1E45FB;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.375rem;">Kelebihan</div>
                    <p style="font-size:.825rem;color: #475569;">{{ $portfolio->mission->review->strengths }}</p>
                </div>
                @endif
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:90px;">
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Detail Project</div>
                @php $details = [
                    ['label'=>'Kategori','value'=>$portfolio->mission?->category?->label() ?? '-'],
                    ['label'=>'UMKM Client','value'=>$portfolio->mission?->creator?->umkmProfile?->business_name ?? '-'],
                    ['label'=>'Diselesaikan','value'=>$portfolio->created_at->format('d M Y')],
                    ['label'=>'Poin Didapat','value'=>($portfolio->mission?->points_reward ?? 0).' pts'],
                ]; @endphp
                @foreach($details as $d)
                <div style="padding:.75rem 0;border-bottom:1px solid rgba(248, 250, 252,0.06);display:flex;justify-content:space-between;align-items:center;">
                    <dt style="font-size:.78rem;color: #475569;">{{ $d['label'] }}</dt>
                    <dd style="font-size:.85rem;font-weight:600;color:#0F172A;text-align:right;max-width:60%;">{{ $d['value'] }}</dd>
                </div>
                @endforeach
            </div>

            @if($portfolio->mission?->progress?->attachment_path)
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1rem;font-size:1rem;">File Project</div>
                <a href="{{ Storage::url($portfolio->mission->progress->attachment_path) }}" target="_blank" class="btn btn-secondary" style="width:100%;justify-content:center;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Download File
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
