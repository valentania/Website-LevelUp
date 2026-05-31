<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    @php
        $profile = $user->mahasiswaProfile;
    @endphp

    <div style="display:grid;grid-template-columns:300px 1fr;gap:1.5rem;align-items:start;">

        {{-- Left Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:90px;">
            <div class="glass-card" style="padding:2rem;text-align:center;">
                <div style="width:100px;height:100px;border-radius:24px;background:#CDF22B;display:flex;align-items:center;justify-content:center;font-size:2.5rem;font-weight:800;color:#0F172A;margin:0 auto 1.25rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h1 style="font-size:1.25rem;font-weight:800;color:#0F172A;margin-bottom:.25rem;">{{ $user->name }}</h1>
                <div style="font-size:.85rem;color: #475569;margin-bottom:.25rem;">
                    {{ $profile?->university ?? 'Universitas tidak dicantumkan' }}
                </div>
                @if($profile?->major)
                <div style="font-size:.75rem;color:rgba(205, 242, 43,0.7);margin-bottom:1.5rem;">{{ $profile->major }}</div>
                @endif

                <div style="display:flex;gap:1rem;margin-bottom:1.5rem;padding:1rem;background:rgba(0, 0, 0, 0.2);border-radius:12px;">
                    <div style="text-align:center;flex:1;">
                        <div style="font-size:1.1rem;font-weight:800;color:#CDF22B;">{{ $profile?->missions_completed ?? 0 }}</div>
                        <div style="font-size:.65rem;color: #475569;text-transform:uppercase;">Mission</div>
                    </div>
                    <div style="text-align:center;flex:1;border-left:1px solid rgba(248, 250, 252,0.06);">
                        <div style="font-size:1.1rem;font-weight:800;color:#CDF22B;">{{ $user->getAverageRating() }}</div>
                        <div style="font-size:.65rem;color: #475569;text-transform:uppercase;">Rating</div>
                    </div>
                </div>

                @if($profile?->cv_path)
                <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:.75rem;">
                    📄 Lihat CV Lengkap
                </a>
                @endif
                @if(auth()->id() === $user->id)
                <a href="{{ route('mahasiswa.profile.edit') }}" class="btn btn-secondary" style="width:100%;justify-content:center;">Edit Profil</a>
                @endif
            </div>

            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1rem;font-size:1rem;">Kontak & Link</div>
                <div style="display:flex;flex-direction:column;gap:.75rem;">
                    @if($profile?->city)
                    <div style="display:flex;align-items:center;gap:.75rem;font-size:.8rem;color: #475569;">
                        <span>📍</span> {{ $profile->city }}
                    </div>
                    @endif
                    <div style="display:flex;align-items:center;gap:.75rem;font-size:.8rem;color: #475569;">
                        <span>✉️</span> {{ $user->email }}
                    </div>
                    @if($profile?->phone)
                    <div style="display:flex;align-items:center;gap:.75rem;font-size:.8rem;color: #475569;">
                        <span>📞</span> {{ $profile->phone }}
                    </div>
                    @endif
                    @if($profile?->linkedin_url)
                    <a href="{{ $profile->linkedin_url }}" target="_blank" style="display:flex;align-items:center;gap:.75rem;font-size:.8rem;color:#475569;text-decoration:none;">
                        <span>💼</span> LinkedIn Profile
                    </a>
                    @endif
                    @if($profile?->github_url)
                    <a href="{{ $profile->github_url }}" target="_blank" style="display:flex;align-items:center;gap:.75rem;font-size:.8rem;color:#475569;text-decoration:none;">
                        <span>🐙</span> GitHub Profile
                    </a>
                    @endif
                    @if($profile?->portfolio_url)
                    <a href="{{ $profile->portfolio_url }}" target="_blank" style="display:flex;align-items:center;gap:.75rem;font-size:.8rem;color:#475569;text-decoration:none;">
                        <span>🌐</span> Personal Website
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1rem;">Tentang Saya</div>
                <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $profile?->bio ?? 'Belum ada deskripsi profil.' }}</p>

                @if($profile?->skills || $user->skills->isNotEmpty())
                <div class="divider"></div>
                <div class="section-title" style="margin-bottom:1rem;">Skills</div>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                    @if($profile?->skills)
                        @foreach(array_map('trim', explode(',', $profile->skills)) as $skill)
                        <span style="padding:4px 12px;border-radius:999px;background:rgba(205, 242, 43,0.08);border:1px solid rgba(205, 242, 43,0.15);font-size:.75rem;font-weight:500;color:#CDF22B;">{{ $skill }}</span>
                        @endforeach
                    @endif
                </div>
                @endif
                
                @if($profile?->interest_fields)
                <div style="margin-top:1.5rem;">
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:rgba(205, 242, 43,0.5);margin-bottom:.5rem;">Minat Bidang</div>
                    <p style="font-size:.85rem;color: #475569;">{{ $profile->interest_fields }}</p>
                </div>
                @endif
            </div>

            @php
                $experiences = [
                    ['title' => 'Pengalaman Kerja / Magang', 'content' => $profile?->work_experience],
                    ['title' => 'Pengalaman Project', 'content' => $profile?->project_experience],
                    ['title' => 'Pengalaman Organisasi', 'content' => $profile?->organization_experience],
                    ['title' => 'Sertifikat & Penghargaan', 'content' => $profile?->certificates],
                ];
            @endphp
            
            @if(collect($experiences)->where('content', '!=', null)->isNotEmpty())
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Pengalaman & Pencapaian</div>
                <div style="display:flex;flex-direction:column;gap:1.5rem;">
                    @foreach($experiences as $exp)
                        @if($exp['content'])
                        <div>
                            <h3 style="font-size:.9rem;font-weight:700;color:#0F172A;margin-bottom:.5rem;">{{ $exp['title'] }}</h3>
                            <p style="font-size:.85rem;color: #475569;line-height:1.7;white-space:pre-line;">{{ $exp['content'] }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            @if($user->portfolios->isNotEmpty())
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Portfolio Projects</div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.25rem;">
                    @foreach($user->portfolios as $portfolio)
                    <div style="background:rgba(0,0,0,0.2);border:1px solid rgba(248, 250, 252, 0.1);border-radius:14px;overflow:hidden;">
                        @if($portfolio->image_path)
                        <div style="width:100%;height:140px;background:url('{{ Storage::url($portfolio->image_path) }}') center/cover;"></div>
                        @else
                        <div style="width:100%;height:140px;background:linear-gradient(135deg,rgba(0,0,0,0.4),#FFFFFF);display:flex;align-items:center;justify-content:center;font-size:2rem;opacity:.5;">💼</div>
                        @endif
                        <div style="padding:1.25rem;">
                            <div style="font-size:.95rem;font-weight:700;color:#0F172A;margin-bottom:.375rem;">{{ $portfolio->title }}</div>
                            <div style="font-size:.75rem;color: #475569;margin-bottom:.75rem;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $portfolio->description }}</div>
                            @if($portfolio->link)
                            <a href="{{ $portfolio->link }}" target="_blank" style="font-size:.75rem;color:#CDF22B;text-decoration:none;font-weight:600;">Lihat Project →</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
</x-app-layout>
