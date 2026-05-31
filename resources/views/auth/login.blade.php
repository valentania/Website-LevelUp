<x-guest-layout>
    <div style="margin-bottom:1.75rem;">
        <h2 style="font-size:1.4rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Masuk ke LevelUp</h2>
        <p style="font-size:.825rem;color:#475569;">Selamat datang kembali! Masukkan kredensial Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf

        <div>
            <label class="input-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="input-field" placeholder="nama@email.com">
            @error('email')<div style="font-size:.72rem;color:#EF4444;margin-top:.375rem;">{{ $message }}</div>@enderror
        </div>

        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                <label class="input-label" style="margin:0;">Password</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:.75rem;color:#1E45FB;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#0F172A'" onmouseout="this.style.color='#1E45FB'">Lupa password?</a>
                @endif
            </div>
            <div style="position:relative;">
                <input id="password" type="password" name="password" required
                    class="input-field" placeholder="••••••••" style="padding-right:3rem;">
                <button type="button" onclick="togglePassword('password','eye-login')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94A3B8;padding:4px;display:flex;align-items:center;transition:color .2s;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#94A3B8'">
                    <svg id="eye-login" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')<div style="font-size:.72rem;color:#EF4444;margin-top:.375rem;">{{ $message }}</div>@enderror
        </div>

        <label style="display:flex;align-items:center;gap:.625rem;cursor:pointer;">
            <input type="checkbox" name="remember" style="width:16px;height:16px;accent-color:#1E45FB;border-radius:4px;">
            <span style="font-size:.825rem;color:#475569;">Ingat saya</span>
        </label>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:.25rem;">
            Masuk ke Dashboard
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

        <div style="text-align:center;font-size:.825rem;color:#475569;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#1E45FB;text-decoration:none;font-weight:600;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Daftar gratis</a>
        </div>
    </form>

    <script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.innerHTML = isHidden
            ? '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
    </script>
</x-guest-layout>
