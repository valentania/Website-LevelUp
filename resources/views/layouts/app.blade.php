<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="LevelUp — Platform Kontribusi Sosial Digital Premium">
    <title>{{ config('app.name', 'LevelUp') }} @isset($pageTitle)— {{ $pageTitle }}@endisset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="antialiased" style="background:#FFFFFF;">

    {{-- Floating Navbar --}}
    @include('layouts.navigation')

    {{-- Page Content --}}
    <div class="page-wrapper">
        <div class="page-container">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div id="toast-success" class="toast toast-success animate-fade-in" style="z-index:999;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                    <span>{{ session('success') }}</span>
                    <button onclick="document.getElementById('toast-success').remove()" class="ml-auto opacity-60 hover:opacity-100" style="margin-left:auto">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div id="toast-error" class="toast toast-error animate-fade-in" style="z-index:999;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('toast-error').remove()" class="ml-auto opacity-60 hover:opacity-100" style="margin-left:auto">✕</button>
                </div>
            @endif
            @if(session('info'))
                <div id="toast-info" class="toast toast-info animate-fade-in" style="z-index:999;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    <span>{{ session('info') }}</span>
                    <button onclick="document.getElementById('toast-info').remove()" class="ml-auto opacity-60 hover:opacity-100" style="margin-left:auto">✕</button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    {{-- Footer --}}
    <footer class="site-footer">
        <div style="max-width:1280px;margin:0 auto;padding:0 1.5rem;">
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem;" class="footer-grid">
                <div>
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem;">
                        <img src="{{ asset('images/logo.png') }}" alt="LevelUp Logo" style="height:32px;width:auto;object-fit:contain;">
                        <span style="font-size:1.25rem;font-weight:800;color:#0F172A;font-family:'Plus Jakarta Sans',sans-serif;">LevelUp</span>
                    </div>
                    <p style="font-size:0.85rem;color:#475569;line-height:1.7;max-width:280px;">Platform kontribusi sosial digital yang menghubungkan mahasiswa berbakat dengan UMKM untuk menciptakan dampak nyata.</p>
                    <div style="display:flex;gap:0.75rem;margin-top:1.25rem;">
                        @foreach([['Instagram','M12 2.163c3.204 0 3.584.012 4.85.07...'],['Twitter','M23 3a10.9 10.9 0 01-3.14 1.53...'],['LinkedIn','M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z']] as $s)
                        <a href="#" style="width:36px;height:36px;border-radius:10px;background:#F8FAFC;border:1px solid rgba(30,69,251,0.08);display:flex;align-items:center;justify-content:center;transition:all .2s;" onmouseover="this.style.borderColor='rgba(30,69,251,0.3)';this.style.background='rgba(30,69,251,0.05)'" onmouseout="this.style.borderColor='rgba(30,69,251,0.08)';this.style.background='#F8FAFC'">
                            <svg width="16" height="16" fill="#1E45FB" viewBox="0 0 24 24"><path d="{{ $s[1] }}"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#475569;margin-bottom:1rem;">Platform</div>
                    @foreach(['Tentang Kami','Cara Kerja','Fitur','Leaderboard'] as $link)
                    <a href="#" style="display:block;font-size:0.875rem;color:#475569;margin-bottom:0.6rem;transition:color .2s;text-decoration:none;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#475569'">{{ $link }}</a>
                    @endforeach
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#475569;margin-bottom:1rem;">Akun</div>
                    @foreach(['Daftar Mahasiswa','Daftar UMKM','Masuk','Reset Password'] as $link)
                    <a href="#" style="display:block;font-size:0.875rem;color:#475569;margin-bottom:0.6rem;transition:color .2s;text-decoration:none;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#475569'">{{ $link }}</a>
                    @endforeach
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#475569;margin-bottom:1rem;">Dukungan</div>
                    @foreach(['FAQ','Hubungi Kami','Kebijakan Privasi','Syarat Penggunaan'] as $link)
                    <a href="#" style="display:block;font-size:0.875rem;color:#475569;margin-bottom:0.6rem;transition:color .2s;text-decoration:none;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#475569'">{{ $link }}</a>
                    @endforeach
                </div>
            </div>
            <div class="divider"></div>
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
                <p style="font-size:0.8rem;color:#94A3B8;">© {{ date('Y') }} LevelUp. All rights reserved.</p>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <div style="width:8px;height:8px;border-radius:50%;background:#22c55e;animation:pulse-glow 2s infinite;"></div>
                    <span style="font-size:0.75rem;color:#94A3B8;">All systems operational</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Auto dismiss toasts
        setTimeout(() => {
            ['toast-success','toast-error','toast-info'].forEach(id => {
                const el = document.getElementById(id);
                if (el) { el.style.opacity='0'; el.style.transform='translateX(100%)'; el.style.transition='all .3s'; setTimeout(()=>el.remove(),300); }
            });
        }, 5000);

        // Navbar scroll effect
        const navbar = document.getElementById('main-navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            });
        }
    </script>

    {{-- ── Custom Confirm Modal ── --}}
    <div id="lu-confirm-backdrop" role="dialog" aria-modal="true" aria-labelledby="lu-confirm-title">
        <div id="lu-confirm-box">
            <div id="lu-confirm-accent-bar"></div>
            <div id="lu-confirm-icon">❓</div>
            <div id="lu-confirm-title">Konfirmasi</div>
            <div id="lu-confirm-msg">Apakah kamu yakin?</div>
            <div id="lu-confirm-actions">
                <button id="lu-confirm-cancel" type="button">Batal</button>
                <button id="lu-confirm-ok" type="button">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
    // ── LevelUp Custom Confirm Modal ──────────────────────────
    (function () {
        let _resolve = null;

        const backdrop = document.getElementById('lu-confirm-backdrop');
        const box      = document.getElementById('lu-confirm-box');
        const iconEl   = document.getElementById('lu-confirm-icon');
        const titleEl  = document.getElementById('lu-confirm-title');
        const msgEl    = document.getElementById('lu-confirm-msg');
        const okBtn    = document.getElementById('lu-confirm-ok');
        const cancelBtn= document.getElementById('lu-confirm-cancel');

        function close(result) {
            backdrop.classList.remove('lu-open');
            if (_resolve) { _resolve(result); _resolve = null; }
        }

        okBtn.addEventListener('click', () => close(true));
        cancelBtn.addEventListener('click', () => close(false));
        backdrop.addEventListener('click', (e) => { if (e.target === backdrop) close(false); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && backdrop.classList.contains('lu-open')) close(false);
            if (e.key === 'Enter'  && backdrop.classList.contains('lu-open')) close(true);
        });

        /**
         * showConfirm(message, options)
         *
         * options:
         *   title      – judul modal
         *   okText     – teks tombol konfirmasi
         *   cancelText – teks tombol batal
         *   type       – 'danger' | 'primary' (default 'primary')
         *   icon       – emoji / HTML icon
         *
         * Returns Promise<boolean>
         */
        window.showConfirm = function (message, options = {}) {
            const isDanger = (options.type === 'danger');
            titleEl.textContent  = options.title      || 'Konfirmasi';
            msgEl.textContent    = message            || 'Apakah kamu yakin?';
            okBtn.textContent    = options.okText     || 'Ya, Lanjutkan';
            cancelBtn.textContent= options.cancelText || 'Batal';
            iconEl.textContent   = options.icon       || (isDanger ? '⚠️' : '🔍');
            iconEl.className     = isDanger ? 'lu-danger' : '';
            okBtn.className      = isDanger ? 'lu-danger-btn' : '';
            backdrop.classList.add('lu-open');
            okBtn.focus();
            return new Promise(r => { _resolve = r; });
        };
    })();
    </script>

    {{-- Real-time Toast Notification Polling --}}
    <div id="toast-container" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column-reverse; gap:10px; pointer-events:none;"></div>

    <script>
    (function () {
        let lastNotifIds = new Set();

        async function pollNotifications() {
            try {
                const res = await fetch('{{ route('notifications.unread') }}', {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();

                let hasNew = false;
                data.notifications.forEach(notif => {
                    if (!lastNotifIds.has(notif.id)) {
                        lastNotifIds.add(notif.id);
                        showNotificationToast(notif);
                        hasNew = true;
                    }
                });

                // Update unread count badge on the bell icon if it exists
                const badge = document.querySelector('#notif-bell-btn span');
                if (badge) {
                    if (data.count > 0) {
                        badge.style.display = 'block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch (e) {}
        }

        function showNotificationToast(notif) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast toast-info animate-fade-in';
            toast.style.cssText = 'pointer-events:auto; position:relative; bottom:auto; right:auto;';

            toast.innerHTML = `
                <div style="font-size:1.25rem; flex-shrink:0;">${notif.icon || '🔔'}</div>
                <div style="flex:1; min-width:0; text-align:left;">
                    <div style="font-size:.8rem; font-weight:700; color:#0F172A; margin-bottom:.15rem;">${notif.title}</div>
                    <div style="font-size:.72rem; color:#475569; line-height:1.4; white-space:normal; overflow:hidden; text-overflow:ellipsis;">${notif.message}</div>
                </div>
                <button onclick="this.parentElement.remove()" style="opacity:.6; cursor:pointer; font-weight:bold; margin-left:8px; border:none; background:none;">✕</button>
            `;

            container.appendChild(toast);

            // Auto dismiss after 6 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                toast.style.transition = 'all .3s';
                setTimeout(() => toast.remove(), 300);
            }, 6000);
        }

        @auth
            // Pre-populate already unread notifications into the set to avoid double popups
            @foreach(auth()->user()->unreadNotifications as $n)
                lastNotifIds.add('{{ $n->id }}');
            @endforeach

            // Poll unread notifications every 5 seconds
            setInterval(pollNotifications, 5000);
        @endauth
    })();
    </script>

    @stack('scripts')

</body>
</html>
