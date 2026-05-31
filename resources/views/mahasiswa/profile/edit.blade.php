<x-app-layout>
<div style="padding:2rem 0;">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin:0;">Edit Profil</h1>
        <a href="{{ route('mahasiswa.dashboard') }}" style="font-size:.825rem;color: #475569;text-decoration:none;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">← Dashboard</a>
    </div>

    <form method="POST" action="{{ route('mahasiswa.profile.update') }}" enctype="multipart/form-data" style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">
        @csrf @method('PUT')

        {{-- Left --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Basic Info --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Informasi Dasar</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    <div>
                        <label class="input-label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input-field" placeholder="Nama lengkap">
                        @error('name')<div style="font-size:.72rem;color:#fca5a5;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="input-label">Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="input-field" style="opacity:.5;cursor:not-allowed;" disabled>
                    </div>
                    <div>
                        <label class="input-label">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}" class="input-field" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <div>
                        <label class="input-label">Domisili / Kota</label>
                        <input type="text" name="city" value="{{ old('city', $profile?->city) }}" class="input-field" placeholder="Jakarta, Surabaya, ...">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="input-label">Bio / Tentang Kamu</label>
                        <textarea name="bio" rows="3" class="input-field" placeholder="Ceritakan sedikit tentang dirimu, minat, dan tujuanmu...">{{ old('bio', $profile?->bio) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Academic --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Informasi Akademik</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    <div>
                        <label class="input-label">Universitas</label>
                        <input type="text" name="university" value="{{ old('university', $profile?->university) }}" class="input-field" placeholder="Universitas Airlangga, ITS, ...">
                    </div>
                    <div>
                        <label class="input-label">Jurusan / Program Studi</label>
                        <input type="text" name="major" value="{{ old('major', $profile?->major) }}" class="input-field" placeholder="Sistem Informasi, DKV, ...">
                    </div>

                </div>
            </div>

            {{-- Skills & Interests --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Skill & Minat</div>
                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    <div>
                        <label class="input-label">Skill (pisahkan dengan koma)</label>
                        <input type="text" name="skills" value="{{ old('skills', is_array($profile?->skills) ? implode(', ', $profile->skills) : $profile?->skills) }}" class="input-field" placeholder="Figma, Laravel, React, Canva, ...">
                        <div style="font-size:.72rem;color:rgba(248, 250, 252, 0.35);margin-top:.375rem;">Contoh: UI Design, Laravel, Copywriting, Canva</div>
                    </div>
                    <div>
                        <label class="input-label">Minat Bidang</label>
                        <input type="text" name="interest_fields" value="{{ old('interest_fields', is_array($profile?->interest_fields) ? implode(', ', $profile->interest_fields) : $profile?->interest_fields) }}" class="input-field" placeholder="Web Design, Digital Marketing, ...">
                    </div>
                </div>
            </div>

            {{-- Experience --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Pengalaman</div>
                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    <div>
                        <label class="input-label">Pengalaman Organisasi</label>
                        <textarea name="organization_experience" rows="3" class="input-field" placeholder="BEM, HMTI, UKM, kepanitiaan, dll...">{{ old('organization_experience', $profile?->organization_experience) }}</textarea>
                    </div>
                    <div>
                        <label class="input-label">Pengalaman Project / Freelance</label>
                        <textarea name="project_experience" rows="3" class="input-field" placeholder="Project freelance, lomba, hackathon, dll...">{{ old('project_experience', $profile?->project_experience) }}</textarea>
                    </div>
                    <div>
                        <label class="input-label">Pengalaman Kerja / Magang</label>
                        <textarea name="work_experience" rows="3" class="input-field" placeholder="Perusahaan, posisi, periode...">{{ old('work_experience', $profile?->work_experience) }}</textarea>
                    </div>
                    <div>
                        <label class="input-label">Sertifikat / Penghargaan</label>
                        <textarea name="certificates" rows="2" class="input-field" placeholder="Google Digital Marketing, AWS Cloud Practitioner, ...">{{ old('certificates', $profile?->certificates) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Links --}}
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">Link Sosial & Portfolio</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    @php $links = [
                        ['name'=>'linkedin_url','label'=>'LinkedIn','icon'=>'💼','placeholder'=>'https://linkedin.com/in/username'],
                        ['name'=>'github_url','label'=>'GitHub','icon'=>'🐙','placeholder'=>'https://github.com/username'],
                        ['name'=>'portfolio_url','label'=>'Website / Portfolio','icon'=>'🌐','placeholder'=>'https://portofolioku.com'],
                        ['name'=>'instagram_url','label'=>'Instagram','icon'=>'📸','placeholder'=>'https://instagram.com/username'],
                    ]; @endphp
                    @foreach($links as $link)
                    <div>
                        <label class="input-label">{{ $link['icon'] }} {{ $link['label'] }}</label>
                        <input type="url" name="{{ $link['name'] }}" value="{{ old($link['name'], $profile?->{$link['name']}) }}" class="input-field" placeholder="{{ $link['placeholder'] }}">
                    </div>
                    @endforeach
                    <div style="grid-column:1/-1;">
                        <label class="input-label">📄 Upload CV (PDF, maks. 5MB)</label>
                        <div id="cv-upload-box" style="border:2px dashed rgba(205, 242, 43,0.2);border-radius:12px;padding:1.5rem;text-align:center;cursor:pointer;position:relative;transition:all .2s;background:rgba(255,255,255,0.02);" onmouseover="this.style.borderColor='rgba(205, 242, 43,0.5)';this.style.background='rgba(255,255,255,0.05)';" onmouseout="this.style.borderColor='rgba(205, 242, 43,0.2)';this.style.background='rgba(255,255,255,0.02)';">
                            <input type="file" id="cv_file" name="cv_file" accept=".pdf" style="position:absolute;inset:0;opacity:0;cursor:pointer;" onchange="handleFileSelect(this)">
                            
                            <div id="upload-idle">
                                <svg style="margin: 0 auto 0.5rem; color: #475569;" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <div style="font-size:.875rem;color: rgba(248, 250, 252, 0.8);">Pilih file PDF atau tarik ke sini</div>
                                <div style="font-size:.75rem;color: #475569;margin-top:0.25rem;">Maksimal ukuran 5MB</div>
                                @if($profile?->cv_path)
                                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                                        <div style="font-size:.8rem;color:rgba(205,242,43,0.9);display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                            CV saat ini tersimpan — <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" style="color:#CDF22B;text-decoration:none;font-weight:600;z-index:10;position:relative;" onclick="event.stopPropagation()">Lihat PDF</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div id="file-selected" style="display:none;background:rgba(205, 242, 43, 0.1);border:1px solid rgba(205, 242, 43, 0.3);padding:1rem;border-radius:8px;text-align:left;">
                                <div style="display:flex;align-items:center;gap:1rem;">
                                    <div style="background:rgba(205, 242, 43, 0.2);padding:0.5rem;border-radius:6px;color:#CDF22B;">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div id="filename-display" style="font-size:0.9rem;font-weight:600;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">filename.pdf</div>
                                        <div id="filesize-display" style="font-size:0.75rem;color: #475569;">0 MB</div>
                                    </div>
                                    <button type="button" onclick="cancelFile(event)" style="background:none;border:none;color:#fca5a5;cursor:pointer;padding:0.5rem;border-radius:4px;z-index:10;position:relative;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                                <div id="upload-progress-container" style="display:none;margin-top:1rem;">
                                    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:#CDF22B;margin-bottom:0.25rem;">
                                        <span>Mengunggah...</span>
                                        <span id="upload-percentage">0%</span>
                                    </div>
                                    <div style="height:4px;background:rgba(255,255,255,0.1);border-radius:2px;overflow:hidden;">
                                        <div id="upload-progress-bar" style="height:100%;width:0%;background:#CDF22B;transition:width 0.2s;"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
        </div>

        {{-- Right Sidebar --}}
        <div style="position:sticky;top:90px;display:flex;flex-direction:column;gap:1.25rem;">
            <div class="glass-card" style="padding:1.5rem;text-align:center;">
                <div style="width:80px;height:80px;border-radius:50%;background:#CDF22B;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#0F172A;margin:0 auto 1rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="font-size:1rem;font-weight:700;color:#0F172A;margin-bottom:.25rem;">{{ auth()->user()->name }}</div>
                <div style="font-size:.8rem;color: #475569;margin-bottom:1rem;">{{ $profile?->university ?? 'Universitas belum diisi' }}</div>
                @php
                    $fields = ['bio','phone','university','major','skills','linkedin_url','github_url'];
                    $filled = collect($fields)->filter(fn($f) => !empty($profile?->$f))->count();
                    $pct = round(($filled / count($fields)) * 100);
                @endphp
                <div style="margin-bottom:.625rem;display:flex;justify-content:space-between;">
                    <span style="font-size:.78rem;color: #475569;">Kelengkapan Profil</span>
                    <span style="font-size:.78rem;font-weight:700;color:#CDF22B;">{{ $pct }}%</span>
                </div>
                <div class="progress-bar-track">
                    <div class="progress-bar-fill" style="width:{{ $pct }}%"></div>
                </div>
            </div>

            <div class="glass-card" style="padding:1.5rem;">
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.875rem;">Tips Profil</div>
                @foreach(['Isi semua field untuk meningkatkan peluang','Tambahkan link portfolio aktif','Upload CV terbaru','Tambahkan skill yang relevan'] as $tip)
                <div style="display:flex;align-items:flex-start;gap:.5rem;margin-bottom:.625rem;font-size:.8rem;color: #475569;">
                    <span style="color:#CDF22B;margin-top:1px;">→</span>{{ $tip }}
                </div>
                @endforeach
            </div>
        </div>
    </form>

</div>
<script>
function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        document.getElementById('upload-idle').style.display = 'none';
        document.getElementById('file-selected').style.display = 'block';
        document.getElementById('filename-display').innerText = file.name;
        document.getElementById('filesize-display').innerText = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
    } else {
        cancelFile();
    }
}
function cancelFile(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    document.getElementById('cv_file').value = '';
    document.getElementById('upload-idle').style.display = 'block';
    document.getElementById('file-selected').style.display = 'none';
    document.getElementById('upload-progress-container').style.display = 'none';
}

document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('cv_file');
    if (fileInput.files.length > 0) {
        document.getElementById('upload-progress-container').style.display = 'block';
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 95) {
                progress = 95;
                clearInterval(interval);
            }
            document.getElementById('upload-progress-bar').style.width = progress + '%';
            document.getElementById('upload-percentage').innerText = Math.round(progress) + '%';
        }, 100);
    }
});
</script>
</x-app-layout>
