<x-app-layout>
<div style="padding:2rem 0; max-width:760px; margin: 0 auto;">

    <a href="{{ route('umkm.missions.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color:#475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Mission Saya
    </a>

    {{-- Check active mission --}}
    @php
        $hasActiveMission = auth()->user()->missions()
            ->whereIn('status',['open','in_progress','pending_review'])
            ->exists();
    @endphp

    @if($hasActiveMission)
    <div style="background:rgba(205,242,43,0.06);border:1px solid rgba(205,242,43,0.3);border-radius:20px;padding:2.5rem;text-align:center;">
        <div style="font-size:2.5rem;margin-bottom:1rem;">⚠️</div>
        <h2 style="font-size:1.25rem;font-weight:700;color:#0F172A;margin-bottom:.625rem;">Mission Aktif Masih Berjalan</h2>
        <p style="font-size:.875rem;color:#475569;max-width:480px;margin:0 auto 1.5rem;">Kamu hanya dapat memiliki 1 mission aktif dalam satu waktu. Selesaikan atau tunggu deadline mission yang sedang berjalan sebelum membuat mission baru.</p>
        <a href="{{ route('umkm.missions.index') }}" class="btn btn-secondary">Lihat Mission Aktif</a>
    </div>
    @else

    <div>
        <div style="margin-bottom:2rem;">
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;font-family:'Plus Jakarta Sans',sans-serif;">Buat Mission Baru</h1>
            <p style="font-size:.875rem;color:#475569;">Jelaskan kebutuhan digital-mu agar mahasiswa dapat membantu dengan tepat</p>
        </div>

        <form method="POST" action="{{ route('umkm.missions.store') }}" style="display:flex;flex-direction:column;gap:1.5rem;">
            @csrf

            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Informasi Mission</div>
                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    <div>
                        <label class="input-label">Judul Mission *</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="input-field" placeholder="Contoh: Bantu desain logo usaha bakso kami" required maxlength="150">
                        @error('title')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="input-label">Deskripsi Lengkap *</label>
                        <textarea name="description" rows="6" class="input-field" placeholder="Ceritakan bisnis Anda, apa yang Anda butuhkan, dan informasi lain yang berguna bagi mahasiswa yang ingin membantu..." required>{{ old('description') }}</textarea>
                        <div style="font-size:.72rem;color:#94A3B8;margin-top:.375rem;">Semakin detail deskripsi, semakin mudah mahasiswa memahami kebutuhan Anda.</div>
                        @error('description')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                        <div>
                            <label class="input-label">Kategori *</label>
                            <select name="category" class="input-field" required>
                                <option value="">Pilih Kategori</option>
                                @foreach(\App\Enums\MissionCategoryEnum::generalCases() as $cat)
                                <option value="{{ $cat->value }}" {{ old('category') === $cat->value ? 'selected' : '' }}>{{ $cat->icon() }} {{ $cat->label() }}</option>
                                @endforeach
                            </select>
                            @error('category')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="input-label">Tingkat Kesulitan</label>
                            <select name="complexity" class="input-field">
                                <option value="" disabled {{ old('complexity') === null ? 'selected' : '' }}>Pilih Tingkat Kesulitan</option>
                                <option value="" {{ old('complexity') === '' ? 'selected' : '' }}>Admin yang memilih</option>
                                <option value="easy"  {{ old('complexity') === 'easy'   ? 'selected' : '' }}>🟢 Mudah</option>
                                <option value="medium"{{ old('complexity') === 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                                <option value="hard"  {{ old('complexity') === 'hard'   ? 'selected' : '' }}>🔴 Sulit</option>
                            </select>
                            <div style="font-size:.7rem;color:#94A3B8;margin-top:.375rem;">Saran Anda, keputusan final ada di admin</div>
                        </div>
                        <div>
                            <label class="input-label">Deadline *</label>
                            <input type="date" name="deadline" value="{{ old('deadline') }}" class="input-field" required min="{{ now()->addDays(3)->format('Y-m-d') }}">
                            @error('deadline')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="input-label">Maks. Pelamar</label>
                            <input type="number" name="max_applicants" value="{{ old('max_applicants', 5) }}" class="input-field" min="1" max="20">
                        </div>
                        <div style="grid-column:1/-1;">
                            <label class="input-label">Skill yang Dibutuhkan (opsional)</label>
                            <input type="text" name="skill_tags" value="{{ old('skill_tags') }}" class="input-field" placeholder="Figma, Canva, Laravel, ...">
                            <div style="font-size:.7rem;color:#94A3B8;margin-top:.25rem;">Pisahkan dengan koma</div>
                        </div>
                    </div>

                    <div>
                        <label class="input-label">Persyaratan (opsional)</label>
                        <textarea name="requirements" rows="3" class="input-field" placeholder="Apa yang harus dimiliki mahasiswa? Pengalaman tertentu, software, alat, dll.">{{ old('requirements') }}</textarea>
                    </div>

                    <div>
                        <label class="input-label">Hasil yang Diharapkan *</label>
                        <div style="position:relative;">
                            <textarea name="deliverables" rows="4" class="input-field" id="deliverables-field" placeholder="Saya mau mendapatkan..." required style="padding-left:1rem;">{{ old('deliverables') }}</textarea>
                        </div>
                        <div style="font-size:.72rem;color:#94A3B8;margin-top:.375rem;">Tuliskan output/hasil konkret yang Anda harapkan dari mahasiswa (file, desain, kode, konten, dll.)</div>
                        @error('deliverables')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div style="background:rgba(30,69,251,0.04);border:1px solid rgba(30,69,251,0.1);border-radius:16px;padding:1.25rem 1.5rem;display:flex;gap:1rem;">
                <div style="font-size:1.25rem;flex-shrink:0;">ℹ️</div>
                <div style="font-size:.825rem;color:#475569;line-height:1.65;">
                    Mission akan <strong style="color:#0F172A;">direview oleh admin</strong> sebelum dipublikasi. Anda boleh menyarankan tingkat kesulitan, namun <strong style="color:#0F172A;">keputusan final ada di admin</strong> saat mereka memvalidasi mission. Proses review biasanya 1x24 jam.
                </div>
            </div>

            <div style="display:flex;gap:.875rem;">
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    Submit Mission untuk Review
                </button>
                <a href="{{ route('umkm.missions.index') }}" class="btn btn-ghost btn-lg">Batal</a>
            </div>
        </form>
    </div>
    @endif

</div>
</x-app-layout>
