<x-guest-layout>
    <div style="margin-bottom:1.75rem;">
        <h2 style="font-size:1.4rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Buat Akun LevelUp</h2>
        <p style="font-size:.825rem;color: #475569;">Bergabung dan mulai perjalanan kontribusi sosialmu!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:1.1rem;">
        @csrf

        <div>
            <label class="input-label">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="input-field" placeholder="Nama lengkap Anda">
            @error('name')<div style="font-size:.72rem;color:#fca5a5;margin-top:.25rem;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="input-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="input-field" placeholder="nama@email.com">
            @error('email')<div style="font-size:.72rem;color:#fca5a5;margin-top:.25rem;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="input-label">Daftar Sebagai</label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.625rem;">
                <label style="cursor:pointer;">
                    <input type="radio" name="role" value="mahasiswa" {{ old('role','mahasiswa')==='mahasiswa'?'checked':'' }} style="display:none;" onchange="updateRoleUI()">
                    <div id="role-mahasiswa" style="padding:.875rem;border-radius:12px;border:1.5px solid rgba(205, 242, 43,0.4);background:rgba(205, 242, 43,0.08);text-align:center;transition:all .2s;">
                        <div style="font-size:1.5rem;margin-bottom:.375rem;">🎓</div>
                        <div style="font-size:.825rem;font-weight:700;color:#CDF22B;">Mahasiswa</div>
                        <div style="font-size:.68rem;color: #475569;margin-top:.2rem;">Kerjakan mission</div>
                    </div>
                </label>
                <label style="cursor:pointer;">
                    <input type="radio" name="role" value="umkm" {{ old('role')==='umkm'?'checked':'' }} style="display:none;" onchange="updateRoleUI()">
                    <div id="role-umkm" style="padding:.875rem;border-radius:12px;border:1.5px solid rgba(248, 250, 252,0.1);background: #F8FAFC;text-align:center;transition:all .2s;opacity:.6;">
                        <div style="font-size:1.5rem;margin-bottom:.375rem;">🏪</div>
                        <div style="font-size:.825rem;font-weight:700;color:#0F172A;">UMKM</div>
                        <div style="font-size:.68rem;color: #475569;margin-top:.2rem;">Buat mission</div>
                    </div>
                </label>
            </div>
            @error('role')<div style="font-size:.72rem;color:#fca5a5;margin-top:.25rem;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="input-label">Password</label>
            <div style="position:relative;">
                <input id="password" type="password" name="password" required
                    class="input-field" placeholder="Min. 8 karakter" style="padding-right:3rem;">
                <button type="button" onclick="togglePassword('password','eye-reg-pass')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94A3B8;padding:4px;display:flex;align-items:center;transition:color .2s;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#94A3B8'">
                    <svg id="eye-reg-pass" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="input-label">Konfirmasi Password</label>
            <div style="position:relative;">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="input-field" placeholder="Ulangi password" style="padding-right:3rem;">
                <button type="button" onclick="togglePassword('password_confirmation','eye-reg-confirm')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94A3B8;padding:4px;display:flex;align-items:center;transition:color .2s;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#94A3B8'">
                    <svg id="eye-reg-confirm" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:.375rem;">
            Buat Akun Gratis
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

        <div style="text-align:center;font-size:.825rem;color: #475569;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#CDF22B;text-decoration:none;font-weight:600;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Masuk</a>
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
    function updateRoleUI() {
        const mah = document.querySelector('[name=role][value=mahasiswa]');
        const umkm = document.querySelector('[name=role][value=umkm]');
        const mahDiv = document.getElementById('role-mahasiswa');
        const umkmDiv = document.getElementById('role-umkm');
        if (mah.checked) {
            mahDiv.style.borderColor='rgba(205, 242, 43,0.4)';mahDiv.style.background='rgba(205, 242, 43,0.08)';mahDiv.style.opacity='1';
            umkmDiv.style.borderColor='rgba(248, 250, 252,0.1)';umkmDiv.style.background='rgba(248, 250, 252,0.04)';umkmDiv.style.opacity='.6';
        } else {
            umkmDiv.style.borderColor='rgba(205,242,43,0.35)';umkmDiv.style.background='rgba(205,242,43,0.08)';umkmDiv.style.opacity='1';
            mahDiv.style.borderColor='rgba(248, 250, 252,0.1)';mahDiv.style.background='rgba(248, 250, 252,0.04)';mahDiv.style.opacity='.6';
        }
    }
    // Set initial state
    document.querySelector('[name=role][value={{ old("role","mahasiswa") }}]').checked = true;
    updateRoleUI();
    document.querySelectorAll('[name=role]').forEach(r => r.addEventListener('change', updateRoleUI));
    </script>
</x-guest-layout>
