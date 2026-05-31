<x-app-layout>
<div style="padding:2rem 0; max-width:760px; margin: 0 auto;">

    <a href="{{ route('umkm.missions.show', $mission) }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color:#475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#1E45FB'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Detail Mission
    </a>

    <div>
        <div style="margin-bottom:2rem;">
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;font-family:'Plus Jakarta Sans',sans-serif;">✏️ Edit Mission</h1>
            <p style="font-size:.875rem;color:#475569;">Perbarui informasi mission kamu</p>
        </div>

        <form method="POST" action="{{ route('umkm.missions.update', $mission) }}" style="display:flex;flex-direction:column;gap:1.5rem;">
            @csrf @method('PUT')

            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Informasi Mission</div>
                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    <div>
                        <label class="input-label">Judul Mission *</label>
                        <input type="text" name="title" value="{{ old('title', $mission->title) }}" class="input-field" placeholder="Contoh: Bantu desain logo usaha bakso kami" required maxlength="150">
                        @error('title')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="input-label">Deskripsi Lengkap *</label>
                        <textarea name="description" rows="6" class="input-field" placeholder="Ceritakan bisnis Anda, apa yang Anda butuhkan..." required>{{ old('description', $mission->description) }}</textarea>
                        @error('description')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                        <div>
                            <label class="input-label">Kategori *</label>
                            <select name="category" class="input-field" required>
                                <option value="">Pilih Kategori</option>
                                @foreach(\App\Enums\MissionCategoryEnum::generalCases() as $cat)
                                <option value="{{ $cat->value }}" {{ old('category', $mission->category->toGeneral()->value) == $cat->value ? 'selected' : '' }}>{{ $cat->icon() }} {{ $cat->label() }}</option>
                                @endforeach
                            </select>
                            @error('category')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="input-label">Tingkat Kesulitan</label>
                            <select name="complexity" class="input-field">
                                <option value="" disabled {{ old('complexity', $mission->complexity?->value) === null ? 'selected' : '' }}>Pilih Tingkat Kesulitan</option>
                                <option value="" {{ old('complexity', $mission->complexity?->value) === '' ? 'selected' : '' }}>Admin yang memilih</option>
                                <option value="easy"   {{ old('complexity', $mission->complexity?->value) === 'easy'   ? 'selected' : '' }}>🟢 Mudah</option>
                                <option value="medium" {{ old('complexity', $mission->complexity?->value) === 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                                <option value="hard"   {{ old('complexity', $mission->complexity?->value) === 'hard'   ? 'selected' : '' }}>🔴 Sulit</option>
                            </select>
                            <div style="font-size:.7rem;color:#94A3B8;margin-top:.375rem;">Saran Anda, keputusan final ada di admin</div>
                        </div>
                        <div>
                            <label class="input-label">Deadline *</label>
                            <input type="date" name="deadline" value="{{ old('deadline', $mission->deadline?->format('Y-m-d')) }}" class="input-field" required min="{{ now()->addDays(1)->format('Y-m-d') }}">
                            @error('deadline')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="input-label">Maks. Pelamar</label>
                            <input type="number" name="max_applicants" value="{{ old('max_applicants', $mission->max_applicants) }}" class="input-field" min="1" max="20">
                        </div>
                    </div>

                    <div>
                        <label class="input-label">Persyaratan (opsional)</label>
                        <textarea name="requirements" rows="3" class="input-field" placeholder="Apa yang harus dimiliki mahasiswa? Pengalaman tertentu, software, dll.">{{ old('requirements', $mission->requirements) }}</textarea>
                    </div>

                    <div>
                        <label class="input-label">Hasil yang Diharapkan *</label>
                        <textarea name="deliverables" rows="4" class="input-field" placeholder="Saya mau mendapatkan..." required>{{ old('deliverables', $mission->deliverables) }}</textarea>
                        @error('deliverables')<div style="font-size:.72rem;color:#EF4444;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:.875rem;">
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('umkm.missions.show', $mission) }}" class="btn btn-ghost btn-lg">Batal</a>
            </div>
        </form>
    </div>

</div>
</x-app-layout>
