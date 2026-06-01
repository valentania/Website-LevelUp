<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Welcome Hero --}}
    <div style="background:linear-gradient(135deg,rgba(30,69,251,0.06),rgba(205,242,43,0.04));border:1px solid rgba(30,69,251,0.1);border-radius:24px;padding:2rem 2.5rem;margin-bottom:2rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(30,69,251,0.06),transparent);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-40px;right:100px;width:150px;height:150px;border-radius:50%;background:radial-gradient(circle,rgba(205,242,43,0.08),transparent);pointer-events:none;"></div>
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;position:relative;z-index:1;">
            <div>
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.5rem;">
                    <div style="width:48px;height:48px;border-radius:14px;background:#1E45FB;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:800;color:#FFFFFF;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;">Selamat Datang Kembali</div>
                        <div style="display:flex;align-items:center;gap:.625rem;flex-wrap:wrap;">
                            <h1 style="font-size:1.4rem;font-weight:800;color:#0F172A;margin:0;font-family:'Plus Jakarta Sans',sans-serif;">{{ $user->name }}</h1>
                            @php $badgeCat = $user->getBadgeCategory(); @endphp
            <span style="font-size:.68rem;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:.06em;background:{{ $badgeCat['bg'] }};color:{{ $badgeCat['color'] }};border:1px solid {{ $badgeCat['border'] }};display:inline-flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.8 15"></path><path d="M12 12A6 6 0 1 0 12 24a6 6 0 1 0 0-12Z"></path><path d="M12 2v10"></path></svg>
                                {{ $badgeCat['name'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <p style="font-size:.875rem;color:#475569;margin:0;">Tingkatkan skill dan portfolio-mu melalui kontribusi nyata bersama LevelUp.</p>
            </div>
            <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Cari Mission
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(30,69,251,0.08);display:flex;align-items:center;justify-content:center;color:#1E45FB;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H4v2h16v-2h-5c-.55 0-1-.45-1-1v-2.34"></path><path d="M12 2a5 5 0 0 0-5 5v3.66a5 5 0 0 0 10 0V7a5 5 0 0 0-5-5z"></path></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(205,242,43,0.2);font-size:.7rem;font-weight:700;color:#0F172A;text-transform:uppercase;letter-spacing:.04em;">Poin</div>
            </div>
            <div class="stat-value">{{ number_format($user->mahasiswaProfile?->total_points ?? 0) }}</div>
            <div class="stat-label">Total Poin</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(34,197,94,0.08);display:flex;align-items:center;justify-content:center;color:#22C55E;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:rgba(30,69,251,0.08);font-size:.7rem;font-weight:700;color:#1E45FB;text-transform:uppercase;letter-spacing:.04em;">Done</div>
            </div>
            <div class="stat-value">{{ $user->mahasiswaProfile?->missions_completed ?? 0 }}</div>
            <div class="stat-label">Mission Selesai</div>
        </div>
        <div class="stat-card">
            @php $badgeCat = $user->getBadgeCategory(); @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:{{ $badgeCat['bg'] }};display:flex;align-items:center;justify-content:center;color:{{ $badgeCat['color'] }};">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.8 15"></path><path d="M12 12A6 6 0 1 0 12 24a6 6 0 1 0 0-12Z"></path><path d="M12 2v10"></path></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:{{ $badgeCat['bg'] }};font-size:.7rem;font-weight:700;color:{{ $badgeCat['color'] }};border:1px solid {{ $badgeCat['border'] }};text-transform:uppercase;letter-spacing:.04em;">Kategori</div>
            </div>
            <div class="stat-value" style="color:{{ $badgeCat['color'] }};font-size:1.6rem;font-weight:800;">{{ $badgeCat['name'] }}</div>
            <div class="stat-label">Kategori Badge</div>
        </div>
        <div class="stat-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(234,179,8,0.08);display:flex;align-items:center;justify-content:center;color:#EAB308;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
                <div style="padding:4px 10px;border-radius:999px;background:#F1F5F9;font-size:.7rem;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.04em;">Rating</div>
            </div>
            <div class="stat-value">{{ $user->getAverageRating() }}<span style="font-size:1rem;font-weight:600;color:#94A3B8;">/5</span></div>
            <div class="stat-label">Rata-rata Rating</div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

        {{-- Active Missions --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div class="section-title" style="margin-bottom:1.25rem;">Mission Aktif</div>
            @php 
                $filteredProgress = $activeProgress->filter(fn($p) => $p->status->value !== 'approved'); 
            @endphp
            @if($filteredProgress->isEmpty())
                <div class="empty-state" style="padding:3rem 1rem;">
                    <div class="empty-state-icon" style="color:#94A3B8;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div class="empty-state-title">Belum Ada Mission Aktif</div>
                    <div class="empty-state-desc">Cari mission yang sesuai skill-mu dan mulai berkontribusi!</div>
                    <a href="{{ route('mahasiswa.missions.browse') }}" class="btn btn-primary btn-sm">Cari Mission</a>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:.75rem;">
                    @foreach($filteredProgress as $progress)
                    <a href="{{ route('mahasiswa.progress.show', $progress) }}" style="display:block;text-decoration:none;padding:1rem 1.25rem;background:#F8FAFC;border:1px solid rgba(30,69,251,0.06);border-radius:14px;transition:all .2s;" onmouseover="this.style.borderColor='#1E45FB';this.style.transform='translateX(4px)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)';this.style.transform='translateX(0)'">
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:.9rem;font-weight:600;color:#0F172A;margin-bottom:.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $progress->mission->title }}</div>
                                <div style="font-size:.75rem;color:#475569;">{{ $progress->mission->creator->umkmProfile?->business_name ?? $progress->mission->creator->name }}</div>
                            </div>
                            @php
                                $statusColors = ['in_progress'=>'badge-blue','submitted'=>'badge-yellow','revision_requested'=>'badge-red','final_submitted'=>'badge-yellow'];
                                $sc = $statusColors[$progress->status->value] ?? 'badge-cream';
                            @endphp
                            <span class="badge {{ $sc }}">{{ $progress->status->label() }}</span>
                        </div>
                        @if($progress->mission->deadline)
                        <div style="display:flex;align-items:center;gap:.375rem;margin-top:.625rem;font-size:.72rem;color:#94A3B8;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                            Deadline: {{ $progress->mission->deadline->format('d M Y') }}
                        </div>
                        @endif
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Badges --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div class="section-title" style="margin-bottom:1.25rem;">Badge Terbaru</div>
            @if($badges->isEmpty())
                <div class="empty-state" style="padding:3rem 1rem;">
                    <div class="empty-state-icon" style="color:#94A3B8;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.8 15"></path><path d="M12 12A6 6 0 1 0 12 24a6 6 0 1 0 0-12Z"></path><path d="M12 2v10"></path></svg>
                    </div>
                    <div class="empty-state-title">Belum Ada Badge</div>
                    <div class="empty-state-desc">Selesaikan mission untuk mendapatkan badge pencapaian!</div>
                </div>
            @else
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                    @foreach($badges->take(4) as $badge)
                    <div style="padding:1rem;background:#F8FAFC;border-radius:14px;border:1px solid rgba(30,69,251,0.06);text-align:center;transition:all .2s;" onmouseover="this.style.borderColor='#1E45FB';this.style.transform='scale(1.02)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)';this.style.transform='scale(1)'">
                        <div style="display:flex;justify-content:center;margin-bottom:.5rem;color:#1E45FB;">
                            @if($badge->slug === 'first-step')
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                            @elseif($badge->slug === 'speed-demon')
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#CDF22B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            @elseif($badge->slug === 'five-star-performer' || $badge->slug === 'rising-star')
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            @elseif(str_starts_with($badge->slug, 'xp-'))
                                @php
                                    $medalColor = '#D97706';
                                    if($badge->slug === 'xp-silver') $medalColor = '#94A3B8';
                                    elseif($badge->slug === 'xp-gold') $medalColor = '#EAB308';
                                    elseif($badge->slug === 'xp-hero') $medalColor = '#8B5CF6';
                                @endphp
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="{{ $medalColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.8 15"></path><path d="M12 12A6 6 0 1 0 12 24a6 6 0 1 0 0-12Z"></path><path d="M12 2v10"></path></svg>
                            @else
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                            @endif
                        </div>
                        <div style="font-size:.825rem;font-weight:600;color:#0F172A;">{{ $badge->name }}</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:.25rem;">{{ Str::limit($badge->description, 40) }}</div>
                    </div>
                    @endforeach
                </div>
                @if($badges->count() > 4)
                <div style="text-align:center;margin-top:1rem;">
                    <span style="font-size:.8rem;color:#1E45FB;font-weight:600;">+{{ $badges->count() - 4 }} badge lainnya</span>
                </div>
                @endif
            @endif
        </div>

    </div>

    {{-- Profile Completeness --}}
    @php
        $profile = $user->mahasiswaProfile;
        $fields = ['bio','phone','linkedin_url','github_url','university','major'];
        $filled = collect($fields)->filter(fn($f) => !empty($profile?->$f))->count();
        $pct = $profile ? round(($filled / count($fields)) * 100) : 0;
    @endphp
    @if($pct < 100)
    <div class="glass-card" style="padding:1.5rem;margin-top:1.5rem;display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.625rem;">
                <span style="font-size:.875rem;font-weight:600;color:#0F172A;">Kelengkapan Profil</span>
                <span style="font-size:.875rem;font-weight:700;color:#1E45FB;">{{ $pct }}%</span>
            </div>
            <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width:{{ $pct }}%"></div>
            </div>
            <div style="font-size:.75rem;color:#475569;margin-top:.5rem;">Lengkapi profilmu agar lebih mudah ditemukan UMKM!</div>
        </div>
        <a href="{{ route('mahasiswa.profile.edit') }}" class="btn btn-secondary btn-sm" style="flex-shrink:0;">Lengkapi Profil →</a>
    </div>
    @endif

    {{-- ⭐ Reviews & Ratings from UMKM --}}
    @if($reviews->isNotEmpty())
    <div class="glass-card" style="padding:1.75rem;margin-top:1.5rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
            <div class="section-title" style="display:flex;align-items:center;gap:.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E45FB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path><path d="M12 7c-1.1-.9-2.9-.9-4 0-1.1.9-1.1 2.9 0 4l4 4 4-4c1.1-1.1 1.1-3.1 0-4-1.1-1-2.9-1-4 0z"></path></svg>
                Feedback dari UMKM
            </div>
            @php
                $avgRating = round($reviews->avg('rating'), 1);
                $totalReviews = $reviews->count();
            @endphp
            <div style="display:flex;align-items:center;gap:.875rem;">
                <div style="text-align:right;">
                    <div style="font-size:1.5rem;font-weight:800;color:#0F172A;line-height:1;">{{ $avgRating }}</div>
                    <div style="font-size:.72rem;color:#94A3B8;">dari {{ $totalReviews }} ulasan</div>
                </div>
                <div style="display:flex;gap:2px;">
                    @for($i=1; $i<=5; $i++)
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $i <= round($avgRating) ? '#CDF22B' : '#E2E8F0' }}" stroke="{{ $i <= round($avgRating) ? '#CDF22B' : '#E2E8F0' }}" stroke-width="1"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            @foreach($reviews->take(5) as $review)
            <div style="background:#F8FAFC;border:1px solid rgba(30,69,251,0.06);border-radius:14px;padding:1.25rem 1.5rem;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(30,69,251,0.18)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.06)'">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:.75rem;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        <div style="width:38px;height:38px;border-radius:11px;background:#1E45FB;display:flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:800;color:#FFFFFF;flex-shrink:0;">
                            {{ strtoupper(substr($review->reviewer->umkmProfile?->business_name ?? $review->reviewer->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:.875rem;font-weight:700;color:#0F172A;">{{ $review->reviewer->umkmProfile?->business_name ?? $review->reviewer->name }}</div>
                            <div style="font-size:.72rem;color:#94A3B8;">{{ $review->mission->title }} · {{ $review->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:2px;flex-shrink:0;">
                        @for($i=1; $i<=5; $i++)
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? '#CDF22B' : '#E2E8F0' }}" stroke="{{ $i <= $review->rating ? '#CDF22B' : '#E2E8F0' }}" stroke-width="1"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @endfor
                        <span style="font-size:.78rem;font-weight:700;color:#0F172A;margin-left:4px;">{{ $review->rating }}/5</span>
                    </div>
                </div>

                @if($review->comment)
                <p style="font-size:.85rem;color:#475569;line-height:1.65;font-style:italic;margin-bottom:{{ ($review->strengths || $review->improvements) ? '.75rem' : '0' }};">"{{ $review->comment }}"</p>
                @endif

                @if($review->strengths || $review->improvements)
                <div style="display:grid;grid-template-columns:{{ $review->strengths && $review->improvements ? '1fr 1fr' : '1fr' }};gap:.75rem;margin-top:.5rem;">
                    @if($review->strengths)
                    <div style="padding:.625rem .875rem;background:rgba(34,197,94,0.06);border:1px solid rgba(34,197,94,0.15);border-radius:10px;">
                        <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#22c55e;margin-bottom:.375rem;display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                            Kelebihan
                        </div>
                        <p style="font-size:.8rem;color:#0F172A;margin:0;line-height:1.5;">{{ $review->strengths }}</p>
                    </div>
                    @endif
                    @if($review->improvements)
                    <div style="padding:.625rem .875rem;background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.15);border-radius:10px;">
                        <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#F59E0B;margin-bottom:.375rem;display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A5 5 0 0 0 8 8c0 1 .2 1.5.7 2M9 18h6M10 22h4"></path></svg>
                            Saran
                        </div>
                        <p style="font-size:.8rem;color:#0F172A;margin:0;line-height:1.5;">{{ $review->improvements }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endforeach

            @if($reviews->count() > 5)
            <div style="text-align:center;padding:.75rem;">
                <span style="font-size:.825rem;color:#1E45FB;font-weight:600;">+{{ $reviews->count() - 5 }} ulasan lainnya</span>
            </div>
            @endif
        </div>
    </div>
    @endif

</div>
</x-app-layout>
