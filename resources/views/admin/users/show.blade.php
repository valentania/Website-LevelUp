<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ route('admin.users.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Pengguna
    </a>

    <div class="glass-card" style="padding:2.5rem;position:relative;overflow:hidden;">
        @if($user->is_suspended)
        <div style="position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:radial-gradient(circle,rgba(248,113,113,0.1),transparent);"></div>
        @else
        <div style="position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:radial-gradient(circle,rgba(205, 242, 43,0.1),transparent);"></div>
        @endif
        
        <div style="display:flex;align-items:center;gap:1.5rem;position:relative;z-index:1;flex-wrap:wrap;">
            <div style="width:80px;height:80px;border-radius:20px;background:rgba(205, 242, 43,0.1);border:1px solid rgba(205, 242, 43,0.2);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                {{ $user->isAdmin() ? '🛡️' : ($user->isMahasiswa() ? '🎓' : '🏪') }}
            </div>
            <div style="flex:1;min-width:0;">
                <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.25rem;">{{ $user->name }}</h1>
                <div style="font-size:.85rem;color: #475569;margin-bottom:.5rem;">{{ $user->email }}</div>
                <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
                    @php
                        $roleColors = ['admin'=>['class'=>'badge-red','icon'=>'🛡️'],'mahasiswa'=>['class'=>'badge-yellow','icon'=>'🎓'],'umkm'=>['class'=>'badge-green','icon'=>'🏪']];
                        $rc = $roleColors[$user->role->value] ?? ['class'=>'badge-cream','icon'=>'👤'];
                    @endphp
                    <span class="badge {{ $rc['class'] }}">{{ $rc['icon'] }} {{ $user->role->label() }}</span>
                    @if($user->is_suspended)
                    <span class="badge badge-red">Suspended</span>
                    @else
                    <span class="badge badge-green">Active</span>
                    @endif
                </div>
            </div>
            
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.suspend', $user) }}" id="suspend-form">
                @csrf
                <button type="button" class="btn {{ $user->is_suspended ? 'btn-primary' : 'btn-danger' }}"
                    onclick="showConfirm('{{ $user->is_suspended ? 'Aktifkan kembali akun ini?' : 'Suspend akun ini? Pengguna tidak akan bisa login.' }}', { title: '{{ $user->is_suspended ? 'Unsuspend Akun' : 'Suspend Akun' }}', okText: '{{ $user->is_suspended ? 'Ya, Aktifkan' : 'Ya, Suspend' }}', type: '{{ $user->is_suspended ? 'primary' : 'danger' }}', icon: '{{ $user->is_suspended ? '✅' : '🚫' }}' }).then(ok => { if(ok) document.getElementById('suspend-form').submit(); })">
                    {{ $user->is_suspended ? '✅ Unsuspend Akun' : '🚫 Suspend Akun' }}
                </button>
            </form>
            @endif
        </div>

        <div class="divider" style="margin:2rem 0;"></div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:2rem;">
            
            {{-- Account Info --}}
            <div>
                <h3 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(205, 242, 43,0.6);margin-bottom:.75rem;">Informasi Akun</h3>
                <div style="display:flex;flex-direction:column;gap:.75rem;">
                    <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                        <span style="font-size:.8rem;color: #475569;">Bergabung Sejak</span>
                        <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                        <span style="font-size:.8rem;color: #475569;">Update Terakhir</span>
                        <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                        <span style="font-size:.8rem;color: #475569;">Status Verifikasi Email</span>
                        <span style="font-size:.85rem;font-weight:600;color:{{ $user->email_verified_at ? '#6ee7b7' : '#fca5a5' }};">{{ $user->email_verified_at ? 'Terverifikasi' : 'Belum' }}</span>
                    </div>
                </div>
            </div>

            {{-- Role Specific Info --}}
            <div>
                @if($user->isMahasiswa())
                    <h3 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(205, 242, 43,0.6);margin-bottom:.75rem;">Profil Mahasiswa</h3>
                    @if($user->mahasiswaProfile)
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Universitas</span>
                            <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->mahasiswaProfile->university ?? '-' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Jurusan</span>
                            <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->mahasiswaProfile->major ?? '-' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Total Poin</span>
                            <span style="font-size:.85rem;font-weight:700;color:#CDF22B;">{{ $user->mahasiswaProfile->total_points }} pts</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Mission Selesai</span>
                            <span style="font-size:.85rem;font-weight:600;color:#1E45FB;">{{ $user->mahasiswaProfile->missions_completed }}</span>
                        </div>
                    </div>
                    <div style="margin-top:1rem;text-align:right;">
                        <a href="{{ route('profiles.show', $user) }}" target="_blank" class="btn btn-ghost btn-sm">Lihat Profil Publik →</a>
                    </div>
                    @else
                    <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:12px;font-size:.8rem;color: #475569;text-align:center;">
                        Pengguna ini belum melengkapi profil mahasiswanya.
                    </div>
                    @endif

                @elseif($user->isUmkm())
                    <h3 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(205, 242, 43,0.6);margin-bottom:.75rem;">Profil UMKM</h3>
                    @if($user->umkmProfile)
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Nama Bisnis</span>
                            <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->umkmProfile->business_name ?? '-' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Tipe Bisnis</span>
                            <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->umkmProfile->business_type ?? '-' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Kota</span>
                            <span style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $user->umkmProfile->city ?? '-' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:.75rem 1rem;background:rgba(0,0,0,0.2);border-radius:12px;">
                            <span style="font-size:.8rem;color: #475569;">Mission Diposting</span>
                            <span style="font-size:.85rem;font-weight:600;color:#1E45FB;">{{ $user->umkmProfile->missions_posted }}</span>
                        </div>
                    </div>
                    <div style="margin-top:1rem;text-align:right;">
                        <a href="{{ route('profiles.show', $user) }}" target="_blank" class="btn btn-ghost btn-sm">Lihat Profil Publik →</a>
                    </div>
                    @else
                    <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:12px;font-size:.8rem;color: #475569;text-align:center;">
                        Pengguna ini belum melengkapi profil UMKM-nya.
                    </div>
                    @endif

                @else
                    <h3 style="font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(205, 242, 43,0.6);margin-bottom:.75rem;">Hak Akses Sistem</h3>
                    <div style="padding:1rem;background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);border-radius:12px;font-size:.85rem;color:#fca5a5;line-height:1.6;">
                        Pengguna ini memiliki hak akses <strong>Administrator</strong>. Administrator memiliki akses penuh ke sistem moderasi, manajemen pengguna, dan dashboard metrik platform.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
</x-app-layout>
