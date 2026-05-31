<x-app-layout>
<div style="padding:2rem 0;">

    {{-- Back --}}
    <a href="{{ route('mahasiswa.applications.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Lamaran
    </a>

    {{-- Workspace Header --}}
    <div style="background:linear-gradient(135deg,#1E45FB,#122FB3);border: 1px solid rgba(255,255,255,0.1);border-radius:24px;padding:2rem;margin-bottom:2rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:radial-gradient(circle,rgba(205, 242, 43,0.1),transparent);"></div>
        <div style="position:relative;z-index:1;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:.75rem;flex-wrap:wrap;">
                <span class="badge badge-yellow">Workspace Aktif</span>
                @php
                    $statusMap = ['in_progress'=>['class'=>'badge-blue','label'=>'Sedang Dikerjakan'],
                        'submitted'=>['class'=>'badge-yellow','label'=>'Sudah Dikirim'],
                        'revision_requested'=>['class'=>'badge-red','label'=>'Perlu Revisi'],
                        'final_submitted'=>['class'=>'badge-yellow','label'=>'Final Dikirim'],
                        'approved'=>['class'=>'badge-green','label'=>'Selesai']];
                    $sc = $statusMap[$progress->status->value] ?? ['class'=>'badge-cream','label'=>$progress->status->label()];
                @endphp
                <span class="badge {{ $sc['class'] }}">{{ $sc['label'] }}</span>
            </div>
            <h1 style="font-size:1.5rem;font-weight:800;color:#FFFFFF;margin-bottom:.5rem;font-family:'Plus Jakarta Sans',sans-serif;">{{ $progress->mission->title }}</h1>
            <div style="display:flex;align-items:center;gap:1rem;font-size:.825rem;color:rgba(255,255,255,0.85);flex-wrap:wrap;">
                <span>🏪 {{ $progress->mission->creator->umkmProfile?->business_name ?? $progress->mission->creator->name }}</span>
                @if($progress->mission->deadline)
                <span>📅 Deadline: {{ $progress->mission->deadline->format('d M Y') }}</span>
                @endif
                <span>⭐ {{ $progress->mission->points_reward }} pts</span>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Left: Upload & Progress --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Revision Note --}}
            @if($progress->status->value === 'revision_requested' && $progress->revision_note)
            <div style="background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.25);border-radius:16px;padding:1.25rem 1.5rem;display:flex;gap:1rem;">
                <div style="font-size:1.5rem;flex-shrink:0;">🔄</div>
                <div>
                    <div style="font-size:.875rem;font-weight:700;color:#fca5a5;margin-bottom:.375rem;">Permintaan Revisi</div>
                    <p style="font-size:.825rem;color: #475569;line-height:1.6;">{{ $progress->revision_note }}</p>
                </div>
            </div>
            @endif

            {{-- Submitted Project Results --}}
            @if(in_array($progress->status->value, ['submitted','revision_requested','final_submitted','approved']) && $progress->progress_note)
            <div class="glass-card" style="padding:2rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem;">
                    <div class="section-title">📄 Hasil yang Dikirim</div>
                    @php
                        $sMap=['submitted'=>['class'=>'badge-yellow','label'=>'Menunggu Review'],
                               'revision_requested'=>['class'=>'badge-red','label'=>'Perlu Revisi'],
                               'final_submitted'=>['class'=>'badge-yellow','label'=>'Final — Menunggu Persetujuan'],
                               'approved'=>['class'=>'badge-green','label'=>'Disetujui']];
                        $ss=$sMap[$progress->status->value]??['class'=>'badge-cream','label'=>$progress->status->label()];
                    @endphp
                    <span class="badge {{ $ss['class'] }}">{{ $ss['label'] }}</span>
                </div>

                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205,242,43,0.5);margin-bottom:.5rem;">Deskripsi Hasil</div>
                <p style="font-size:.875rem;color:#94A3B8;line-height:1.7;white-space:pre-line;margin-bottom:1.25rem;">{{ $progress->progress_note }}</p>

                @if($progress->submission_link)
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205,242,43,0.5);margin-bottom:.5rem;">Link Project</div>
                    <a href="{{ $progress->submission_link }}" target="_blank" style="display:inline-flex;align-items:center;gap:.5rem;padding:.625rem 1rem;background:rgba(205,242,43,0.08);border:1px solid rgba(205,242,43,0.2);border-radius:10px;font-size:.85rem;color:#CDF22B;text-decoration:none;word-break:break-all;" onmouseover="this.style.background='rgba(205,242,43,0.15)'" onmouseout="this.style.background='rgba(205,242,43,0.08)'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        {{ $progress->submission_link }}
                    </a>
                </div>
                @endif

                @if($progress->attachment_path)
                <div>
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205,242,43,0.5);margin-bottom:.5rem;">File Lampiran</div>
                    <a href="{{ Storage::url($progress->attachment_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download File Lampiran
                    </a>
                </div>
                @endif
            </div>
            @endif


            {{-- Upload Form --}}
            @if(!in_array($progress->status->value, ['approved']))
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">
                    {{ $progress->status->value === 'revision_requested' ? '🔄 Upload Revisi' : '📤 Upload Hasil Project' }}
                </div>

                <form method="POST" action="{{ route('mahasiswa.progress.update', $progress) }}" enctype="multipart/form-data" id="upload-form">
                    @csrf @method('PUT')

                    <div style="margin-bottom:1.25rem;">
                        <label class="input-label">Deskripsi Hasil *</label>
                        <textarea name="progress_note" rows="4" class="input-field" placeholder="Jelaskan apa yang sudah kamu kerjakan, pendekatan yang digunakan, dan hasil yang dicapai..." required>{{ old('progress_note', $progress->progress_note) }}</textarea>
                        @error('progress_note')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom:1.25rem;">
                        <label class="input-label">Link Project (Google Drive / GitHub / Figma / URL)</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color: #94A3B8;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                            <input type="url" name="submission_link" value="{{ old('submission_link', $progress->submission_link ?? '') }}" class="input-field" style="padding-left:2.5rem;" placeholder="https://drive.google.com/... atau https://github.com/...">
                        </div>
                        @error('submission_link')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom:1.75rem;">
                        <label class="input-label">Upload File (PDF, ZIP, PNG, JPG — maks. 10MB)</label>
                        <div id="dropzone" style="border:2px dashed rgba(205, 242, 43,0.2);border-radius:14px;padding:2rem;text-align:center;cursor:pointer;transition:all .2s;position:relative;" onmouseover="this.style.borderColor='rgba(205, 242, 43,0.4)';this.style.background='rgba(205, 242, 43,0.04)'" onmouseout="this.style.borderColor='rgba(205, 242, 43,0.2)';this.style.background='transparent'">
                            <input type="file" name="attachment" id="file-input" style="position:absolute;inset:0;opacity:0;cursor:pointer;" accept=".pdf,.zip,.png,.jpg,.jpeg,.figma" onchange="updateFileName(this)">
                            <div id="file-placeholder">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(205, 242, 43,0.4)" stroke-width="1.5" style="margin:0 auto .75rem;display:block;"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <div style="font-size:.875rem;font-weight:600;color: #475569;">Drag & drop atau klik untuk pilih file</div>
                                <div style="font-size:.75rem;color: #94A3B8;margin-top:.375rem;">PDF, ZIP, PNG, JPG — maks. 10MB</div>
                            </div>
                            <div id="file-selected" style="display:none;font-size:.875rem;font-weight:600;color:#CDF22B;"></div>
                        </div>
                        @if($progress->attachment_path)
                        <div style="display:flex;align-items:center;gap:.5rem;margin-top:.75rem;font-size:.8rem;color: #475569;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                            File sebelumnya:
                            <a href="{{ Storage::url($progress->attachment_path) }}" target="_blank" style="color:#CDF22B;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Lihat File</a>
                        </div>
                        @endif
                        @error('attachment')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>

                    <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                        <button type="submit" name="action" value="save" class="btn btn-secondary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Draft
                        </button>
                        <button type="button" class="btn btn-primary" onclick="showConfirm('Kirim hasil project ke UMKM untuk direview?', { title: 'Kirim ke UMKM', okText: 'Ya, Kirim!', icon: '📤' }).then(ok => { if(ok) { const h=document.createElement('input'); h.type='hidden'; h.name='action'; h.value='submit'; document.getElementById('upload-form').appendChild(h); document.getElementById('upload-form').submit(); } })">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            Kirim ke UMKM
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div style="background:rgba(205,242,43,0.08);border:1px solid rgba(205,242,43,0.2);border-radius:20px;padding:2rem;text-align:center;">
                <div style="font-size:2.5rem;margin-bottom:1rem;">🎉</div>
                <h3 style="font-size:1.15rem;font-weight:700;color:#1E45FB;margin-bottom:.5rem;">Project Disetujui!</h3>
                <p style="font-size:.875rem;color: #475569;">Selamat! UMKM telah menyetujui hasil kerjamu. Poin telah ditambahkan ke akunmu.</p>
                @if($progress->mission->portfolio)
                <a href="{{ route('mahasiswa.portfolio.show', $progress->mission->portfolio) }}" class="btn btn-primary" style="margin-top:1.25rem;">Lihat Portfolio →</a>
                @endif
            </div>
            @endif

            {{-- Chat / Discussion (Real-time) --}}
            <div class="glass-card" style="padding:2rem;" id="chat-section">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                    <div class="section-title">💬 Ruang Diskusi</div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:.72rem;color:#94A3B8;">
                        <div style="width:7px;height:7px;border-radius:50%;background:#22c55e;animation:pulse-glow 2s infinite;"></div>
                        Live
                    </div>
                </div>

                <div id="chat-messages" style="display:flex;flex-direction:column;gap:1rem;margin-bottom:1.5rem;max-height:420px;overflow-y:auto;padding-right:8px;scroll-behavior:smooth;">
                    @forelse($progress->messages as $msg)
                        @php $isMe = $msg->sender_id === auth()->id(); @endphp
                        <div style="display:flex;flex-direction:column;align-items:{{ $isMe ? 'flex-end' : 'flex-start' }};">
                            <div style="font-size:.68rem;color:#94A3B8;margin-bottom:.25rem;padding:0 4px;">{{ $isMe ? 'Kamu' : ($msg->sender->umkmProfile?->business_name ?? $msg->sender->name) }} · {{ $msg->created_at->format('d M H:i') }}</div>
                            <div style="background:{{ $isMe ? 'rgba(30,69,251,0.08)' : '#F8FAFC' }};border:1px solid {{ $isMe ? 'rgba(30,69,251,0.15)' : 'rgba(30,69,251,0.06)' }};padding:.75rem 1rem;border-radius:12px;border-{{ $isMe ? 'bottom-right' : 'bottom-left' }}-radius:0;max-width:85%;font-size:.875rem;color:#0F172A;line-height:1.5;white-space:pre-wrap;">{{ $msg->message }}</div>
                        </div>
                    @empty
                        <div id="empty-chat" style="text-align:center;padding:2.5rem 1rem;font-size:.875rem;color:#94A3B8;">
                            <div style="font-size:2rem;margin-bottom:.5rem;">💬</div>
                            Belum ada pesan. Mulai diskusi dengan UMKM di sini!
                        </div>
                    @endforelse
                </div>

                @if($progress->status->value !== 'approved')
                <div style="display:flex;gap:.75rem;align-items:stretch;">
                    <input type="text" id="chat-input" class="input-field" placeholder="Ketik pesan... (Enter untuk kirim)" style="flex:1;" onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMessage();}">
                    <button onclick="sendMessage()" class="btn btn-primary" style="padding:.625rem 1.5rem;flex-shrink:0;min-width:110px;display:flex;align-items:center;gap:.5rem;" id="send-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        <span style="font-size:.85rem;font-weight:600;">Kirim</span>
                    </button>
                </div>
                @else
                <div style="padding:1rem;text-align:center;background:#F8FAFC;border-radius:12px;font-size:.85rem;color:#94A3B8;">
                    Diskusi telah ditutup karena project sudah disetujui.
                </div>
                @endif
            </div>

        </div>

        {{-- Right Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:90px;">

            {{-- Mission Brief --}}
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Brief Mission</div>
                @if($progress->mission->deliverables)
                <div style="margin-bottom:1rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.5rem;">Yang Diharapkan</div>
                    <p style="font-size:.825rem;color: #475569;line-height:1.65;white-space:pre-line;">{{ Str::limit($progress->mission->deliverables, 200) }}</p>
                </div>
                @endif
                @if($progress->mission->requirements)
                <div>
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.5rem;">Persyaratan</div>
                    <p style="font-size:.825rem;color: #475569;line-height:1.65;white-space:pre-line;">{{ Str::limit($progress->mission->requirements, 150) }}</p>
                </div>
                @endif
            </div>

            {{-- Status Timeline --}}
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Status Progress</div>
                @php $statuses = [
                    ['value'=>'in_progress','label'=>'Dikerjakan','icon'=>'⚡'],
                    ['value'=>'submitted','label'=>'Dikirim','icon'=>'📤'],
                    ['value'=>'revision_requested','label'=>'Revisi','icon'=>'🔄'],
                    ['value'=>'final_submitted','label'=>'Final','icon'=>'✅'],
                    ['value'=>'approved','label'=>'Selesai','icon'=>'🏆'],
                ];
                $currentIdx = array_search($progress->status->value, array_column($statuses,'value'));
                @endphp
                @foreach($statuses as $i => $st)
                <div style="display:flex;align-items:center;gap:.75rem;{{ $i < count($statuses)-1 ? 'margin-bottom:.625rem;' : '' }}">
                    <div style="width:32px;height:32px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;
                        {{ $i <= $currentIdx ? 'background:rgba(205, 242, 43,0.15);border:1px solid rgba(205, 242, 43,0.3);' : 'background: #F8FAFC;border: 1px solid #475569;opacity:.4;' }}">
                        {{ $st['icon'] }}
                    </div>
                    <span style="font-size:.825rem;font-weight:{{ $i === $currentIdx ? '700' : '400' }};color:{{ $i <= $currentIdx ? '#F8FAFC' : 'rgba(248, 250, 252, 0.35)' }};">{{ $st['label'] }}</span>
                    @if($i === $currentIdx)
                    <span class="badge badge-yellow" style="margin-left:auto;font-size:.65rem;">Sekarang</span>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const placeholder = document.getElementById('file-placeholder');
    const selected = document.getElementById('file-selected');
    if (input.files.length > 0) {
        placeholder.style.display = 'none';
        selected.style.display = 'block';
        selected.textContent = '📎 ' + input.files[0].name;
        document.getElementById('dropzone').style.borderColor = 'rgba(30,69,251,0.4)';
        document.getElementById('dropzone').style.background = 'rgba(30,69,251,0.04)';
    }
}

// ── Real-time Chat ──────────────────────────────────────────────
const PROGRESS_ID = {{ $progress->id }};
const MSG_URL     = '{{ route('progress.messages.store', $progress) }}';
const POLL_URL    = '{{ route('progress.messages.index', $progress) }}';
const CSRF        = '{{ csrf_token() }}';
let lastTs = '{{ $progress->messages->last()?->created_at?->toIso8601String() ?? '' }}';

function buildBubble(msg) {
    const align = msg.isMe ? 'flex-end' : 'flex-start';
    const bg    = msg.isMe ? 'rgba(30,69,251,0.08)' : '#F8FAFC';
    const border= msg.isMe ? 'rgba(30,69,251,0.15)' : 'rgba(30,69,251,0.06)';
    const corner= msg.isMe ? 'bottom-right' : 'bottom-left';
    return `<div style="display:flex;flex-direction:column;align-items:${align};">
        <div style="font-size:.68rem;color:#94A3B8;margin-bottom:.25rem;padding:0 4px;">${msg.sender} · ${msg.created_at}</div>
        <div style="background:${bg};border:1px solid ${border};padding:.75rem 1rem;border-radius:12px;border-${corner}-radius:0;max-width:85%;font-size:.875rem;color:#0F172A;line-height:1.5;white-space:pre-wrap;">${escHtml(msg.message)}</div>
    </div>`;
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function scrollBottom() {
    const box = document.getElementById('chat-messages');
    if (box) box.scrollTop = box.scrollHeight;
}

function appendMessage(msg) {
    const empty = document.getElementById('empty-chat');
    if (empty) empty.remove();
    const box = document.getElementById('chat-messages');
    if (box) {
        const el = document.createElement('div');
        el.innerHTML = buildBubble(msg);
        box.appendChild(el.firstChild);
        scrollBottom();
        if (msg.ts) lastTs = msg.ts;
    }
}

async function sendMessage() {
    const input = document.getElementById('chat-input');
    const btn   = document.getElementById('send-btn');
    const text  = input?.value?.trim();
    if (!text) return;

    input.disabled = true;
    btn.disabled   = true;
    btn.style.opacity = '.5';

    try {
        const res = await fetch(MSG_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ message: text }),
            credentials: 'same-origin'
        });
        const data = await res.json();
        if (data.success) {
            appendMessage(data.message);
            input.value = '';
        }
    } catch (e) { console.error(e); }

    input.disabled = false;
    btn.disabled   = false;
    btn.style.opacity = '1';
    input.focus();
}

async function pollMessages() {
    try {
        const url = POLL_URL + (lastTs ? '?since=' + encodeURIComponent(lastTs) : '');
        const res = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
        const data = await res.json();
        data.messages?.forEach(appendMessage);
    } catch (e) {}
}

// Poll every 3 seconds
scrollBottom();
setInterval(pollMessages, 3000);
</script>
</x-app-layout>
