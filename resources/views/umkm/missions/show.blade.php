<x-app-layout>
<div style="padding:2rem 0;">

    <a href="{{ route('umkm.missions.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.825rem;color: #475569;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#475569'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Mission Saya
    </a>

    @php
        $statusMap=['open'=>'badge-green','pending_review'=>'badge-yellow','in_progress'=>'badge-blue','completed'=>'badge-cream','rejected'=>'badge-red'];
        $sc=$statusMap[$mission->status->value]??'badge-cream';
        $cxMap=['easy'=>'complexity-easy','medium'=>'complexity-medium','hard'=>'complexity-hard'];
    @endphp

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Mission Header --}}
            <div class="glass-card" style="padding:2rem;">
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
                    <span class="badge {{ $sc }}">{{ $mission->status->label() }}</span>
                    <span class="badge badge-cream">{{ $mission->category->label() }}</span>
                    @if($mission->complexity)
                    <span class="badge {{ $cxMap[$mission->complexity->value]??'badge-cream' }}">{{ $mission->complexity->label() }}</span>
                    @endif
                </div>
                <h1 style="font-size:1.5rem;font-weight:800;color:#0F172A;margin-bottom:1rem;">{{ $mission->title }}</h1>

                @if($mission->rejection_reason)
                <div style="background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);border-radius:14px;padding:1rem 1.25rem;margin-bottom:1rem;display:flex;gap:.75rem;">
                    <span style="flex-shrink:0;">❌</span>
                    <div>
                        <div style="font-size:.825rem;font-weight:700;color:#fca5a5;margin-bottom:.25rem;">Mission Ditolak Admin</div>
                        <p style="font-size:.8rem;color: #475569;">{{ $mission->rejection_reason }}</p>
                    </div>
                </div>
                @endif

                <div class="divider"></div>
                <div style="margin-bottom:1rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Deskripsi</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->description }}</p>
                </div>
                @if($mission->deliverables)
                <div>
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(205, 242, 43,0.5);margin-bottom:.625rem;">Yang Diharapkan</div>
                    <p style="font-size:.9rem;color: #475569;line-height:1.75;white-space:pre-line;">{{ $mission->deliverables }}</p>
                </div>
                @endif
            </div>

            {{-- Progress / Submission --}}
            @if($mission->progress)
            <div class="glass-card" style="padding:2rem;" x-data="{ showRevision: false }">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
                    <div class="section-title">📊 Hasil Pengerjaan</div>
                    @php
                        $pxMap=['in_progress'=>'badge-blue','submitted'=>'badge-yellow','revision_requested'=>'badge-red','final_submitted'=>'badge-yellow','approved'=>'badge-green'];
                        $pxc=$pxMap[$mission->progress->status->value]??'badge-cream';
                    @endphp
                    <span class="badge {{ $pxc }}">{{ $mission->progress->status->label() }}</span>
                </div>

                <div style="display:flex;align-items:center;gap:.875rem;margin-bottom:1.25rem;padding:1rem;background:rgba(30,69,251,0.04);border:1px solid rgba(30,69,251,0.1);border-radius:14px;">
                    <div style="width:44px;height:44px;border-radius:12px;background:#CDF22B;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;color:#1E45FB;flex-shrink:0;">
                        {{ strtoupper(substr($mission->progress->mahasiswa->name,0,1)) }}
                    </div>
                    <div>
                        <div style="font-size:.9rem;font-weight:700;color:#0F172A;">{{ $mission->progress->mahasiswa->name }}</div>
                        <div style="font-size:.75rem;color:#475569;">{{ $mission->progress->mahasiswa->mahasiswaProfile?->university ?? '' }}</div>
                    </div>
                    <a href="{{ route('profiles.show', $mission->progress->mahasiswa) }}" style="margin-left:auto;font-size:.75rem;color:#1E45FB;text-decoration:none;white-space:nowrap;font-weight:600;" onmouseover="this.style.color='#0F172A'" onmouseout="this.style.color='#1E45FB'">Lihat Profil →</a>
                </div>

                @if($mission->progress->progress_note)
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;margin-bottom:.625rem;">Deskripsi Hasil</div>
                    <p style="font-size:.875rem;color: #475569;line-height:1.7;white-space:pre-line;">{{ $mission->progress->progress_note }}</p>
                </div>
                @endif

                @if($mission->progress->submission_link)
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#1E45FB;margin-bottom:.5rem;">Link Project</div>
                    <a href="{{ $mission->progress->submission_link }}" target="_blank" style="display:inline-flex;align-items:center;gap:.5rem;padding:.625rem 1rem;background:rgba(205, 242, 43,0.08);border:1px solid rgba(205, 242, 43,0.2);border-radius:10px;font-size:.85rem;color:#CDF22B;text-decoration:none;" onmouseover="this.style.background='rgba(205, 242, 43,0.15)'" onmouseout="this.style.background='rgba(205, 242, 43,0.08)'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        {{ $mission->progress->submission_link }}
                    </a>
                </div>
                @endif

                @if($mission->progress->attachment_path)
                <div style="margin-bottom:1.5rem;">
                    <a href="{{ Storage::url($mission->progress->attachment_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download File Lampiran
                    </a>
                </div>
                @endif

                {{-- Submission Pending Banner --}}
                @if(in_array($mission->progress->status->value, ['submitted','final_submitted']))
                <div style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:12px;padding:.875rem 1.25rem;display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
                    <span style="font-size:1.25rem;">📬</span>
                    <div>
                        <div style="font-size:.825rem;font-weight:700;color:#fbbf24;margin-bottom:.15rem;">{{ $mission->progress->status->value === 'final_submitted' ? 'Final Submission — Menunggu Persetujuan Anda' : 'Mahasiswa Telah Mengirim Hasil' }}</div>
                        <div style="font-size:.75rem;color:#94A3B8;">Tinjau hasil di bawah, lalu Approve atau minta Revisi.</div>
                    </div>
                </div>
                @endif

                {{-- Approve / Revision Actions --}}
                @if(in_array($mission->progress->status->value, ['submitted','final_submitted']))
                <div style="padding-top:1.25rem;border-top:1px solid rgba(248, 250, 252,0.08);">
                    <div style="display:flex;gap:.875rem;flex-wrap:wrap;margin-bottom:1rem;">
                        <form method="POST" action="{{ route('umkm.progress.approve', $mission->progress) }}" id="approve-form">
                            @csrf
                            <button type="button" class="btn btn-primary" onclick="showConfirm('Setujui hasil project ini dan selesaikan mission?', { title: 'Approve Project', okText: 'Ya, Approve!', icon: '✅' }).then(ok => { if(ok) document.getElementById('approve-form').submit(); })">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                                Approve & Selesaikan
                            </button>
                        </form>
                        <button type="button" @click="showRevision = !showRevision" class="btn btn-secondary">
                            🔄 Minta Revisi
                        </button>
                    </div>
                    <div x-show="showRevision" x-cloak style="background:rgba(205, 242, 43,0.04);border:1px solid rgba(205, 242, 43,0.15);border-radius:14px;padding:1.25rem;">
                        <form method="POST" action="{{ route('umkm.progress.revision', $mission->progress) }}">
                            @csrf
                            <label class="input-label">Catatan Revisi *</label>
                            <textarea name="revision_note" rows="3" class="input-field" placeholder="Jelaskan apa yang perlu diperbaiki..." required style="margin-bottom:.875rem;"></textarea>
                            <button type="submit" class="btn btn-primary btn-sm">Kirim Permintaan Revisi</button>
                        </form>
                    </div>
                </div>
                @endif

                @if($mission->progress->status->value === 'approved')
                <div style="padding:.875rem 1rem;background:rgba(205,242,43,0.08);border:1px solid rgba(205,242,43,0.2);border-radius:12px;text-align:center;font-size:.875rem;font-weight:600;color:#1E45FB;">
                    ✓ Project telah diapprove — Mission Selesai!
                </div>
                @endif
            </div>

            {{-- Chat / Discussion (Real-time) --}}
            <div class="glass-card" style="padding:2rem;" id="chat-section">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                    <div class="section-title">💬 Ruang Diskusi</div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:.72rem;color:#475569;">
                        <div style="width:7px;height:7px;border-radius:50%;background:#22c55e;animation:pulse-glow 2s infinite;"></div>
                        Live
                    </div>
                </div>

                <div id="chat-messages" style="display:flex;flex-direction:column;gap:1rem;margin-bottom:1.5rem;max-height:420px;overflow-y:auto;padding-right:8px;scroll-behavior:smooth;">
                    @forelse($mission->progress->messages as $msg)
                        @php $isMe = $msg->sender_id === auth()->id(); @endphp
                        <div style="display:flex;flex-direction:column;align-items:{{ $isMe ? 'flex-end' : 'flex-start' }};">
                            <div style="font-size:.68rem;color:#64748B;margin-bottom:.25rem;padding:0 4px;">{{ $isMe ? 'Kamu' : $msg->sender->name }} · {{ $msg->created_at->format('d M H:i') }}</div>
                            <div style="background:{{ $isMe ? 'rgba(30,69,251,0.08)' : '#F8FAFC' }};border:1px solid {{ $isMe ? 'rgba(30,69,251,0.15)' : 'rgba(30,69,251,0.06)' }};padding:.75rem 1rem;border-radius:12px;border-{{ $isMe ? 'bottom-right' : 'bottom-left' }}-radius:0;max-width:85%;font-size:.875rem;color:#0F172A;line-height:1.5;white-space:pre-wrap;">{{ $msg->message }}</div>
                        </div>
                    @empty
                        <div id="empty-chat" style="text-align:center;padding:2.5rem 1rem;font-size:.875rem;color:#94A3B8;">
                            <div style="font-size:2rem;margin-bottom:.5rem;">💬</div>
                            Belum ada pesan. Mulai diskusi dengan mahasiswa di sini!
                        </div>
                    @endforelse
                </div>

                @if($mission->progress->status->value !== 'approved')
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
            @endif

            {{-- Review Form --}}
            @if($mission->status->value === 'completed' && !$mission->review)
            <div class="glass-card" style="padding:2rem;">
                <div class="section-title" style="margin-bottom:1.5rem;">⭐ Berikan Review</div>
                <form method="POST" action="{{ route('umkm.review.store', $mission) }}">
                    @csrf
                    <div style="margin-bottom:1.25rem;" x-data="{ rating: 5, hover: 0 }">
                        <label class="input-label">Rating</label>
                        <div style="display:flex;gap:.5rem;margin-top:.5rem;">
                            @for($i = 1; $i <= 5; $i++)
                            <label style="cursor:pointer;" @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0" @click="rating = {{ $i }}">
                                <input type="radio" name="rating" value="{{ $i }}" style="display:none;" x-model="rating">
                                <span style="font-size:2rem;transition:all .2s;" :style="(hover ? hover >= {{ $i }} : rating >= {{ $i }}) ? 'opacity:1;' : 'opacity:.3;'">⭐</span>
                            </label>
                            @endfor
                        </div>
                        @error('rating')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label class="input-label">Komentar * (minimal 10 karakter)</label>
                        <textarea name="comment" rows="3" class="input-field" placeholder="Bagaimana hasil kerja mahasiswa ini?" required>{{ old('comment') }}</textarea>
                        @error('comment')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label class="input-label">Kelebihan (opsional)</label>
                        <textarea name="strengths" rows="2" class="input-field" placeholder="Apa yang sudah sangat baik?">{{ old('strengths') }}</textarea>
                        @error('strengths')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>
                    <div style="margin-bottom:1.5rem;">
                        <label class="input-label">Saran Perbaikan (opsional)</label>
                        <textarea name="improvements" rows="2" class="input-field" placeholder="Apa yang bisa lebih baik lagi?">{{ old('improvements') }}</textarea>
                        @error('improvements')<div style="font-size:.75rem;color:#fca5a5;margin-top:.375rem;">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Review</button>
                </form>
            </div>
            @endif

            @if($mission->review)
            <div class="glass-card" style="padding:1.75rem;">
                <div class="section-title" style="margin-bottom:1.25rem;">Review Anda</div>
                <div style="display:flex;gap:3px;margin-bottom:.75rem;">
                    @for($i=1;$i<=5;$i++)
                    <span style="font-size:1.25rem;opacity:{{ $i<=$mission->review->rating?'1':'.2' }};">⭐</span>
                    @endfor
                </div>
                <p style="font-size:.9rem;color: #475569;line-height:1.7;font-style:italic;">"{{ $mission->review->comment }}"</p>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:90px;">
            <div class="glass-card" style="padding:1.5rem;">
                <div class="section-title" style="margin-bottom:1.25rem;font-size:1rem;">Info Mission</div>
                @php $infos=[
                    ['label'=>'Poin Reward','value'=>$mission->points_reward.' pts'],
                    ['label'=>'Deadline','value'=>$mission->deadline?->format('d M Y')??'-'],
                    ['label'=>'Maks. Pelamar','value'=>$mission->max_applicants],
                    ['label'=>'Total Pelamar','value'=>$mission->applications->count()],
                    ['label'=>'Dibuat','value'=>$mission->created_at->format('d M Y')],
                ]; @endphp
                @foreach($infos as $info)
                <div style="padding:.625rem 0;border-bottom:1px solid rgba(248, 250, 252,0.06);display:flex;justify-content:space-between;">
                    <dt style="font-size:.78rem;color: #475569;">{{ $info['label'] }}</dt>
                    <dd style="font-size:.85rem;font-weight:600;color:#0F172A;">{{ $info['value'] }}</dd>
                </div>
                @endforeach
            </div>

            @if($mission->status->value === 'open' && $mission->applications->isNotEmpty())
            <div class="glass-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div class="section-title" style="font-size:1rem;">Pelamar</div>
                    <a href="{{ route('umkm.missions.applicants', $mission) }}" style="font-size:.75rem;color:rgba(205, 242, 43,0.7);text-decoration:none;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='rgba(205, 242, 43,0.7)'">Lihat Semua →</a>
                </div>
                @foreach($mission->applications->take(3) as $app)
                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 0;border-bottom:1px solid rgba(248, 250, 252,0.06);">
                    <div style="width:32px;height:32px;border-radius:10px;background:rgba(205, 242, 43,0.1);display:flex;align-items:center;justify-content:center;font-size:.875rem;font-weight:700;color:#CDF22B;">{{ strtoupper(substr($app->mahasiswa->name,0,1)) }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.825rem;font-weight:600;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $app->mahasiswa->name }}</div>
                        <div style="font-size:.7rem;color:#64748B;">{{ $app->mahasiswa->mahasiswaProfile?->university ?? '' }}</div>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('umkm.missions.applicants', $mission) }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;margin-top:1rem;">Kelola Pelamar ({{ $mission->applications->count() }})</a>
            </div>
            @endif

            <div style="display:flex;gap:.625rem;flex-direction:column;">
                @if(in_array($mission->status->value,['open','rejected']))
                <a href="{{ route('umkm.missions.edit', $mission) }}" class="btn btn-ghost btn-sm" style="justify-content:center;">Edit Mission</a>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>

<script>
@if($mission->progress)
const MSG_URL  = '{{ route('progress.messages.store', $mission->progress) }}';
const POLL_URL = '{{ route('progress.messages.index', $mission->progress) }}';
const CSRF     = '{{ csrf_token() }}';
let lastTs = '{{ $mission->progress->messages->last()?->created_at?->toIso8601String() ?? '' }}';

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function buildBubble(msg) {
    const align  = msg.isMe ? 'flex-end' : 'flex-start';
    const bg     = msg.isMe ? 'rgba(30,69,251,0.08)' : '#F8FAFC';
    const border = msg.isMe ? 'rgba(30,69,251,0.15)' : 'rgba(30,69,251,0.06)';
    const corner = msg.isMe ? 'bottom-right' : 'bottom-left';
    const bubble = document.createElement('div');
    bubble.style.cssText = `display:flex;flex-direction:column;align-items:${align};`;
    bubble.innerHTML = `<div style="font-size:.68rem;color:#94A3B8;margin-bottom:.25rem;padding:0 4px;">${escHtml(msg.sender)} · ${escHtml(msg.created_at)}</div><div style="background:${bg};border:1px solid ${border};padding:.75rem 1rem;border-radius:12px;border-${corner}-radius:0;max-width:85%;font-size:.875rem;color:#0F172A;line-height:1.5;white-space:pre-wrap;">${escHtml(msg.message)}</div>`;
    return bubble;
}
function scrollBottom() {
    const box = document.getElementById('chat-messages');
    if (box) box.scrollTop = box.scrollHeight;
}
const renderedMsgIds = new Set();
@if($mission->progress)
    @foreach($mission->progress->messages as $msg)
        renderedMsgIds.add({{ $msg->id }});
    @endforeach
@endif

function appendMessage(msg) {
    if (msg.id && renderedMsgIds.has(msg.id)) return;
    if (msg.id) renderedMsgIds.add(msg.id);
    
    const empty = document.getElementById('empty-chat');
    if (empty) empty.remove();
    const box = document.getElementById('chat-messages');
    if (box) {
        box.appendChild(buildBubble(msg));
        scrollBottom();
        if (msg.ts) lastTs = msg.ts;
    }
}
function showChatError(msg) {
    const input = document.getElementById('chat-input');
    if (!input) return;
    const errEl = document.createElement('div');
    errEl.style.cssText = 'font-size:.75rem;color:#EF4444;margin-top:.375rem;';
    errEl.textContent = msg;
    input.parentNode.appendChild(errEl);
    setTimeout(() => errEl.remove(), 4000);
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
        const res  = await fetch(MSG_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ message: text }),
            credentials: 'same-origin'
        });
        const data = await res.json();
        if (data.success) {
            appendMessage(data.message);
            input.value = '';
        } else {
            showChatError(data.error ?? 'Pesan gagal terkirim.');
        }
    } catch(e) {
        console.error(e);
        showChatError('Terjadi kesalahan jaringan. Coba lagi.');
    }
    input.disabled = false;
    btn.disabled   = false;
    btn.style.opacity = '1';
    input.focus();
}
async function pollMessages() {
    try {
        const url  = POLL_URL + (lastTs ? '?since=' + encodeURIComponent(lastTs) : '');
        const res  = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
        const data = await res.json();
        if (Array.isArray(data.messages)) data.messages.forEach(appendMessage);
    } catch(e) {}
}
scrollBottom();
setInterval(pollMessages, 3000);
@endif
</script>
