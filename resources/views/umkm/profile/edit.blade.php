<x-app-layout>
<div style="padding:2rem 0;">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin:0;">Edit Profil Bisnis</h1>
        <a href="{{ route('umkm.dashboard') }}" style="font-size:.825rem;color: #475569;text-decoration:none;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">← Dashboard</a>
    </div>

    @if(session('success'))
        <div style="padding:1rem 1.25rem;background:rgba(30,69,251,0.08);border:1px solid rgba(205,242,43,0.2);border-radius:12px;color:#1E45FB;font-size:.9rem;margin-bottom:1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('umkm.profile.update') }}" style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">
        @csrf @method('PUT')

        {{-- Left --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Info Pemilik --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Informasi Pemilik</div>
                <div>
                    <label class="input-label">Nama Pemilik *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                    @error('name')<div style="font-size:.72rem;color:#fca5a5;margin-top:.25rem;">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Info Bisnis --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Informasi Bisnis</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    <div>
                        <label class="input-label">Nama Bisnis / UMKM *</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $profile?->business_name) }}" class="input-field" placeholder="Warung Makan Bahagia" required>
                        @error('business_name')<div style="font-size:.72rem;color:#fca5a5;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="input-label">Jenis Bisnis</label>
                        <select name="business_type" class="input-field">
                            <option value="">-- Pilih --</option>
                            @foreach(['Kuliner', 'Fashion', 'Jasa', 'Kerajinan', 'Pertanian', 'Pendidikan', 'Teknologi', 'Lainnya'] as $type)
                                <option value="{{ $type }}" {{ old('business_type', $profile?->business_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="input-label">Deskripsi Bisnis</label>
                        <textarea name="business_description" rows="4" class="input-field" placeholder="Ceritakan tentang bisnis Anda...">{{ old('business_description', $profile?->business_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kontak & Lokasi --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Kontak & Lokasi</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    <div>
                        <label class="input-label">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $profile?->city) }}" class="input-field" placeholder="Jakarta, Surabaya...">
                    </div>
                    <div>
                        <label class="input-label">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}" class="input-field" placeholder="08xxxxxxxxxx">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="input-label">Alamat Lengkap</label>
                        <textarea name="address" rows="2" class="input-field" placeholder="Jl. ...">{{ old('address', $profile?->address) }}</textarea>
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="input-label">Website (opsional)</label>
                        <input type="url" name="website" value="{{ old('website', $profile?->website) }}" class="input-field" placeholder="https://...">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan Profil
            </button>
        </div>

        {{-- Right Sidebar --}}
        <div style="position:sticky;top:90px;display:flex;flex-direction:column;gap:1.25rem;">
            <div class="glass-card" style="padding:1.5rem;text-align:center;">
                <div style="width:80px;height:80px;border-radius:50%;background:#CDF22B;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#0F172A;margin:0 auto 1rem;">
                    🏪
                </div>
                <div style="font-size:1rem;font-weight:700;color:#0F172A;margin-bottom:.25rem;">{{ $profile?->business_name ?? 'Bisnis Belum Dinamai' }}</div>
                <div style="font-size:.8rem;color: #475569;margin-bottom:1rem;">{{ $profile?->business_type ?? 'Jenis belum diisi' }}</div>
            </div>
            
            <div class="glass-card" style="padding:1.5rem;">
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.875rem;">Tips UMKM</div>
                @foreach(['Lengkapi profil untuk meningkatkan kepercayaan mahasiswa','Gunakan deskripsi yang menarik','Berikan kontak yang mudah dihubungi'] as $tip)
                <div style="display:flex;align-items:flex-start;gap:.5rem;margin-bottom:.625rem;font-size:.8rem;color: #475569;">
                    <span style="color:#CDF22B;margin-top:1px;">→</span>{{ $tip }}
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
</x-app-layout>
