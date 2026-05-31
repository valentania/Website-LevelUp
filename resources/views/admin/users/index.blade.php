<x-app-layout>
<div style="padding:2rem 0;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F172A;margin-bottom:.375rem;">Kelola Pengguna</h1>
            <p style="font-size:.875rem;color: #475569;">Pantau dan kelola semua pengguna platform</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" style="margin-bottom:1.5rem;">
        <div style="background:rgba(0, 0, 0, 0.2);border: 1px solid rgba(248, 250, 252, 0.1);border-radius:20px;padding:1.25rem 1.5rem;display:flex;flex-wrap:wrap;align-items:flex-end;gap:1rem;">
            <div style="flex:1;min-width:200px;">
                <label class="input-label">Cari Pengguna</label>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Nama atau email..." class="input-field">
            </div>
            <div style="min-width:140px;">
                <label class="input-label">Role</label>
                <select name="role" class="input-field">
                    <option value="">Semua Role</option>
                    <option value="mahasiswa" {{ request('role')==='mahasiswa'?'selected':'' }}>Mahasiswa</option>
                    <option value="umkm" {{ request('role')==='umkm'?'selected':'' }}>UMKM</option>
                    <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if(request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">Reset</a>
            @endif
        </div>
    </form>

    {{-- Stats Summary --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;margin-bottom:2rem;">
        @php
            $roleCounts = \App\Models\User::selectRaw('role, count(*) as count')->groupBy('role')->pluck('count','role');
        @endphp
        <div class="stat-card">
            <div style="font-size:1.5rem;margin-bottom:.5rem;">👥</div>
            <div class="stat-value" style="font-size:1.75rem;">{{ $users->total() }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div style="font-size:1.5rem;margin-bottom:.5rem;">🎓</div>
            <div class="stat-value" style="font-size:1.75rem;">{{ $roleCounts['mahasiswa'] ?? 0 }}</div>
            <div class="stat-label">Mahasiswa</div>
        </div>
        <div class="stat-card">
            <div style="font-size:1.5rem;margin-bottom:.5rem;">🏪</div>
            <div class="stat-value" style="font-size:1.75rem;">{{ $roleCounts['umkm'] ?? 0 }}</div>
            <div class="stat-label">UMKM</div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="glass-card" style="padding:1.75rem;">
        <div class="section-title" style="margin-bottom:1.5rem;">Daftar Pengguna</div>
        @if($users->isEmpty())
            <div class="empty-state" style="padding:3rem 1rem;">
                <div class="empty-state-icon" style="margin:0 auto 1rem;">👥</div>
                <div class="empty-state-title">Tidak Ada Pengguna</div>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:.625rem;">
                @foreach($users as $user)
                @php
                    $roleColors = ['admin'=>['class'=>'badge-red','icon'=>'🛡️'],'mahasiswa'=>['class'=>'badge-yellow','icon'=>'🎓'],'umkm'=>['class'=>'badge-green','icon'=>'🏪']];
                    $rc = $roleColors[$user->role->value] ?? ['class'=>'badge-cream','icon'=>'👤'];
                @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;background: #F8FAFC;border:1px solid rgba(205, 242, 43,0.06);border-radius:14px;gap:1rem;flex-wrap:wrap;transition:all .2s;" onmouseover="this.style.borderColor='rgba(205, 242, 43,0.2)'" onmouseout="this.style.borderColor='rgba(205, 242, 43,0.06)'">
                    <div style="display:flex;align-items:center;gap:.875rem;flex:1;min-width:0;">
                        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,rgba(205, 242, 43,0.15),rgba(205, 242, 43,0.05));border:1px solid rgba(205, 242, 43,0.15);display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:.9rem;font-weight:600;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $user->name }}</div>
                            <div style="font-size:.75rem;color: #475569;">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;flex-shrink:0;">
                        <span class="badge {{ $rc['class'] }}">{{ $rc['icon'] }} {{ $user->role->label() }}</span>
                        @if($user->is_suspended)
                        <span class="badge badge-red">Suspended</span>
                        @endif
                        <span style="font-size:.72rem;color:rgba(248, 250, 252, 0.35);">{{ $user->created_at->format('d M Y') }}</span>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost btn-sm">Detail</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="margin-top:1.5rem;display:flex;justify-content:center;">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
</x-app-layout>
