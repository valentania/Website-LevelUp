<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    @php
        $profile = $user->umkmProfile;
    @endphp

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

        {{-- Main Content --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            <div class="glass-card" style="padding:2.5rem;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:radial-gradient(circle,rgba(205, 242, 43,0.1),transparent);"></div>
                
                <div style="display:flex;align-items:center;gap:1.5rem;position:relative;z-index:1;flex-wrap:wrap;">
                    <div style="width:80px;height:80px;border-radius:20px;background:rgba(205, 242, 43,0.1);border:1px solid rgba(205, 242, 43,0.2);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                        🏪
                    </div>
                    <div style="flex:1;min-width:0;">
                        <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.25rem;">{{ $profile?->business_name ?? $user->name }}</h1>
                        <div style="display:flex;align-items:center;gap:.75rem;font-size:.85rem;color: #475569;flex-wrap:wrap;">
                            @if($profile?->business_type)
                            <span style="padding:4px 10px;border-radius:999px;background:rgba(0,0,0,0.2);color:#0F172A;">{{ $profile->business_type }}</span>
                            @endif
                            @if($profile?->city)
                            <span>📍 {{ $profile->city }}</span>
                            @endif
                        </div>
                    </div>
                    @if(auth()->id() === $user->id)
                    <a href="{{ route('umkm.profile.edit') }}" class="btn btn-ghost">Edit Profil Bisnis</a>
                    @endif
                </div>

                <div class="divider" style="margin:2rem 0;"></div>

                <div style="margin-bottom:2rem;">
                    <h3 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(205, 242, 43,0.6);margin-bottom:.75rem;">Tentang Bisnis</h3>
                    <p style="font-size:.95rem;color:rgba(248, 250, 252, 0.8);line-height:1.75;white-space:pre-line;">{{ $profile?->business_description ?? 'Belum ada deskripsi bisnis.' }}</p>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;">
                    @if($profile?->phone)
                    <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                        <div style="font-size:.7rem;color: #475569;margin-bottom:.25rem;text-transform:uppercase;">Kontak</div>
                        <div style="font-size:.9rem;color:#0F172A;font-weight:600;">📞 {{ $profile->phone }}</div>
                    </div>
                    @endif
                    @if($profile?->website)
                    <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                        <div style="font-size:.7rem;color: #475569;margin-bottom:.25rem;text-transform:uppercase;">Website</div>
                        <a href="{{ $profile->website }}" target="_blank" style="font-size:.9rem;color:#CDF22B;font-weight:600;text-decoration:none;">🌐 Kunjungi Web →</a>
                    </div>
                    @endif
                    <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                        <div style="font-size:.7rem;color: #475569;margin-bottom:.25rem;text-transform:uppercase;">Email</div>
                        <div style="font-size:.9rem;color:#0F172A;font-weight:600;">✉️ {{ $user->email }}</div>
                    </div>
                </div>
                
                @if($profile?->address)
                <div style="margin-top:1.5rem;padding:1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                    <div style="font-size:.7rem;color: #475569;margin-bottom:.375rem;text-transform:uppercase;">Alamat Lengkap</div>
                    <div style="font-size:.85rem;color:#0F172A;line-height:1.5;">{{ $profile->address }}</div>
                </div>
                @endif
            </div>

            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Mission Terbaru UMKM Ini</div>
                
                @if($user->missions->isEmpty())
                <div style="text-align:center;padding:2rem;color: #475569;font-size:.9rem;">
                    Belum ada mission yang diposting.
                </div>
                @else
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @foreach($user->missions as $mission)
                    <a href="{{ auth()->user()->isMahasiswa() ? route('mahasiswa.missions.show', $mission) : route('umkm.missions.show', $mission) }}" style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;background:rgba(0,0,0,0.2);border:1px solid rgba(248, 250, 252, 0.05);border-radius:12px;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='rgba(205, 242, 43,0.2)'" onmouseout="this.style.borderColor='rgba(248, 250, 252, 0.05)'">
                        <div>
                            <div style="font-size:.95rem;font-weight:600;color:#0F172A;margin-bottom:.25rem;">{{ $mission->title }}</div>
                            <div style="font-size:.75rem;color: #475569;">
                                {{ $mission->points_reward }} pts • 
                                @if($mission->status->value === 'open') <span style="color:#1E45FB;">Menerima Pelamar</span> 
                                @elseif($mission->status->value === 'pending_review') <span style="color:#fcd34d;">Pending Review</span>
                                @elseif($mission->status->value === 'in_progress') <span style="color:#60a5fa;">Sedang Dikerjakan</span>
                                @else <span style="color: #475569;">Selesai</span> @endif
                            </div>
                        </div>
                        <div style="color: #94A3B8;">→</div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:90px;">
            <div class="glass-card" style="padding:1.5rem;text-align:center;">
                <div style="font-size:.75rem;color: #475569;text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Statistik UMKM</div>
                
                <div style="font-size:2.5rem;font-weight:800;color:#CDF22B;line-height:1;">{{ $profile?->missions_posted ?? 0 }}</div>
                <div style="font-size:.85rem;color:#0F172A;margin-bottom:1.5rem;margin-top:.25rem;">Total Mission Dibuat</div>
                
                <div class="divider" style="margin:1rem 0;"></div>
                
                <div style="font-size:2.5rem;font-weight:800;color:#1E45FB;line-height:1;">{{ $user->missions->where('status.value', 'completed')->count() }}</div>
                <div style="font-size:.85rem;color:#0F172A;margin-top:.25rem;">Mission Selesai</div>
            </div>

            <div class="glass-card" style="padding:1.5rem;">
                <div style="font-size:.75rem;color: #475569;text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Pemilik Akun</div>
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(248, 250, 252, 0.1);display:flex;align-items:center;justify-content:center;color:#0F172A;font-weight:700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->name }}</div>
                        <div style="font-size:.7rem;color: #475569;">Bergabung {{ $user->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
