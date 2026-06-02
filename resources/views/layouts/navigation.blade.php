<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .nav-links-container::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .nav-links-container {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    @media (max-width: 640px) {
        .navbar {
            padding: 0 0.5rem !important;
            gap: 6px !important;
            height: 56px !important;
        }
        .navbar .nav-link {
            font-size: 0.72rem !important;
            padding: 0.3rem 0.5rem !important;
            white-space: nowrap !important;
        }
        .brand-text {
            display: none !important; /* Hide LevelUp text to save space on mobile */
        }
        .role-badge {
            display: none !important;
        }
        .user-dropdown-name {
            display: none !important;
        }
        .user-dropdown-btn {
            padding: 4px !important;
        }
    }
</style>

<nav id="main-navbar" x-data="{ open: false, userOpen: false }" class="navbar">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;flex-shrink:0;">
        <img src="{{ asset('images/logo.png') }}" alt="LevelUp Logo" style="height:36px;width:auto;object-fit:contain;">
        <span class="brand-text" style="font-size:1.1rem;font-weight:800;color:#0F172A;font-family:'Plus Jakarta Sans',sans-serif;">LevelUp</span>
    </a>

    {{-- Nav Links --}}
    <div class="nav-links-container flex items-center overflow-x-auto" style="gap:4px; max-width: 50%; -webkit-overflow-scrolling: touch;">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Pengguna</a>
                <a href="{{ route('admin.missions.index') }}" class="nav-link {{ request()->routeIs('admin.missions.*') ? 'active' : '' }}">Moderasi</a>
            @elseif(auth()->user()->isMahasiswa())
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('mahasiswa.missions.browse') }}" class="nav-link {{ request()->routeIs('mahasiswa.missions.*') ? 'active' : '' }}">Cari Mission</a>
                <a href="{{ route('mahasiswa.applications.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.applications.*') ? 'active' : '' }}">Lamaran</a>
                <a href="{{ route('mahasiswa.portfolio.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.portfolio.*') ? 'active' : '' }}">Portfolio</a>
            @elseif(auth()->user()->isUmkm())
                <a href="{{ route('umkm.dashboard') }}" class="nav-link {{ request()->routeIs('umkm.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('umkm.missions.index') }}" class="nav-link {{ request()->routeIs('umkm.missions.*') && !request()->routeIs('umkm.missions.create') ? 'active' : '' }}">Mission Saya</a>
                <a href="{{ route('umkm.missions.create') }}" class="nav-link {{ request()->routeIs('umkm.missions.create') ? 'active' : '' }}">Buat Mission</a>
            @endif
        @endauth
    </div>

    {{-- Right: User Info + Dropdown --}}
    <div class="flex items-center" style="gap:1rem; flex-shrink:0;">
        @auth
            {{-- Points badge for mahasiswa --}}
            @if(auth()->user()->isMahasiswa())
                <div style="display:flex;align-items:center;gap:6px;padding:4px 12px;border-radius:999px;background:rgba(205,242,43,0.15);border:1px solid rgba(205,242,43,0.4);">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#CDF22B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span style="font-size:0.78rem;font-weight:700;color:#0F172A;">{{ auth()->user()->mahasiswaProfile?->total_points ?? 0 }} pts</span>
                </div>
            @endif

            {{-- Notification Bell --}}
            @php $unreadNotifs = auth()->user()->unreadNotifications->take(8); @endphp
            <div class="relative" x-data="{ notifOpen: false }">
                <button @click="notifOpen = !notifOpen" style="position:relative;width:36px;height:36px;border-radius:10px;background:#F8FAFC;border:1px solid rgba(30,69,251,0.08);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor='rgba(30,69,251,0.2)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.08)'" id="notif-bell-btn">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                    @if($unreadNotifs->count() > 0)
                    <span style="position:absolute;top:4px;right:4px;width:8px;height:8px;border-radius:50%;background:#EF4444;border:2px solid #FFFFFF;"></span>
                    @endif
                </button>

                <div x-show="notifOpen" @click.away="notifOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-cloak
                    style="position:absolute;right:0;top:calc(100% + 8px);width:340px;background:#FFFFFF;border:1px solid rgba(30,69,251,0.1);border-radius:16px;box-shadow:0 20px 40px -10px rgba(30,69,251,0.12);z-index:200;overflow:hidden;">
                    <div style="padding:12px 16px;border-bottom:1px solid rgba(30,69,251,0.06);display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:.875rem;font-weight:700;color:#0F172A;">🔔 Notifikasi</span>
                        @if($unreadNotifs->count() > 0)
                        <form method="POST" action="{{ route('notifications.read-all') }}" style="display:inline;">
                            @csrf
                            <button type="submit" style="font-size:.7rem;color:#1E45FB;background:none;border:none;cursor:pointer;font-weight:600;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Tandai semua dibaca</button>
                        </form>
                        @endif
                    </div>
                    <div style="max-height:340px;overflow-y:auto;">
                        @forelse($unreadNotifs as $notif)
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" style="display:block;">
                            @csrf
                            <button type="submit" style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;width:100%;text-align:left;background:rgba(30,69,251,0.03);border:none;border-bottom:1px solid rgba(30,69,251,0.04);cursor:pointer;transition:background .15s;" onmouseover="this.style.background='rgba(30,69,251,0.07)'" onmouseout="this.style.background='rgba(30,69,251,0.03)'">
                                <span style="font-size:1.25rem;flex-shrink:0;line-height:1;">{{ $notif->data['icon'] ?? '🔔' }}</span>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:.8rem;font-weight:700;color:#0F172A;margin-bottom:.15rem;">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
                                    <div style="font-size:.75rem;color:#475569;line-height:1.4;white-space:normal;overflow:hidden;text-overflow:ellipsis;">{{ $notif->data['message'] ?? '' }}</div>
                                    <div style="font-size:.68rem;color:#94A3B8;margin-top:.3rem;">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                                <div style="width:8px;height:8px;border-radius:50%;background:#1E45FB;flex-shrink:0;margin-top:4px;"></div>
                            </button>
                        </form>
                        @empty
                        <div style="padding:2rem 1rem;text-align:center;font-size:.85rem;color:#94A3B8;">
                            <div style="font-size:1.75rem;margin-bottom:.5rem;">🔕</div>
                            Tidak ada notifikasi baru
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Role badge --}}
            <span class="role-badge" style="font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.06em;
                {{ auth()->user()->isAdmin() ? 'background:rgba(239,68,68,0.08);color:#EF4444;border:1px solid rgba(239,68,68,0.2);' : '' }}
                {{ auth()->user()->isMahasiswa() ? 'background:rgba(30,69,251,0.08);color:#1E45FB;border:1px solid rgba(30,69,251,0.15);' : '' }}
                {{ auth()->user()->isUmkm() ? 'background:rgba(205,242,43,0.2);color:#0F172A;border:1px solid rgba(205,242,43,0.4);' : '' }}">
                {{ auth()->user()->role->label() }}
            </span>

            {{-- User Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="user-dropdown-btn" style="display:flex;align-items:center;gap:8px;padding:5px 12px 5px 5px;border-radius:12px;background:#F8FAFC;border:1px solid rgba(30,69,251,0.08);cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor='rgba(30,69,251,0.2)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.08)'">
                    <div style="width:28px;height:28px;border-radius:8px;background:#1E45FB;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;color:#FFFFFF;flex-shrink:0;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="user-dropdown-name" style="font-size:0.85rem;font-weight:500;color:#0F172A;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->name }}</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" :style="open ? 'transform:rotate(180deg)' : ''" style="transition:transform .2s;flex-shrink:0;"><path d="M6 9l6 6 6-6"/></svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-cloak
                    style="position:absolute;right:0;top:calc(100% + 8px);min-width:200px;background:#FFFFFF;border:1px solid rgba(30,69,251,0.1);border-radius:14px;padding:8px;box-shadow:0 20px 40px -10px rgba(30,69,251,0.08);z-index:200;">
                    <div style="padding:8px 12px 10px;border-bottom:1px solid rgba(30,69,251,0.06);margin-bottom:6px;">
                        <div style="font-size:0.8rem;font-weight:600;color:#0F172A;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.72rem;color:#475569;margin-top:2px;">{{ Auth::user()->email }}</div>
                    </div>
                    @if(auth()->user()->isMahasiswa())
                        <a href="{{ route('profiles.show', auth()->user()) }}" style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:9px;font-size:0.85rem;color:#475569;transition:all .2s;text-decoration:none;" onmouseover="this.style.background='rgba(30,69,251,0.06)';this.style.color='#1E45FB'" onmouseout="this.style.background='transparent';this.style.color='#475569'">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Profil
                        </a>
                        <a href="{{ route('mahasiswa.profile.edit') }}" style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:9px;font-size:0.85rem;color:#475569;transition:all .2s;text-decoration:none;" onmouseover="this.style.background='rgba(30,69,251,0.06)';this.style.color='#1E45FB'" onmouseout="this.style.background='transparent';this.style.color='#475569'">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/></svg>
                            Edit Profil
                        </a>
                    @elseif(auth()->user()->isUmkm())
                        <a href="{{ route('profiles.show', auth()->user()) }}" style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:9px;font-size:0.85rem;color:#475569;transition:all .2s;text-decoration:none;" onmouseover="this.style.background='rgba(30,69,251,0.06)';this.style.color='#1E45FB'" onmouseout="this.style.background='transparent';this.style.color='#475569'">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Profil Bisnis
                        </a>
                        <a href="{{ route('umkm.profile.edit') }}" style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:9px;font-size:0.85rem;color:#475569;transition:all .2s;text-decoration:none;" onmouseover="this.style.background='rgba(30,69,251,0.06)';this.style.color='#1E45FB'" onmouseout="this.style.background='transparent';this.style.color='#475569'">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Edit Profil Bisnis
                        </a>
                    @endif
                    <div style="height:1px;background:rgba(30,69,251,0.06);margin:6px 0;"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:9px;font-size:0.85rem;color:#EF4444;transition:all .2s;width:100%;text-align:left;background:transparent;border:none;cursor:pointer;" onmouseover="this.style.background='rgba(239,68,68,0.06)'" onmouseout="this.style.background='transparent'">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">Daftar</a>
        @endauth
    </div>
</nav>
