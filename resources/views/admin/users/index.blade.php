@extends('layouts.master')

@section('content')
<div class="um-wrapper">

    {{-- Header --}}
    <div class="um-header">
        <div>
            <h2 class="um-title">Manajemen User</h2>
            <p class="um-subtitle">Kelola akun dan hak akses pengguna</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="um-btn-add">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah User
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="um-alert">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Card --}}
    <div class="um-card">
        <table class="um-table">
            <thead>
                <tr>
                    <th style="width: 52px;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>
                    <td>
                        <div class="um-avatar-row">
                            <div class="um-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <span class="um-name">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="td-email">{{ $user->email }}</td>
                    <td>
                        <span class="um-badge">{{ $user->role->name }}</span>
                    </td>
                    <td>
                        <div class="um-actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="um-btn-edit" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin ingin menghapus user {{ addslashes($user->name) }}?')"
                                    class="um-btn-delete"
                                    title="Hapus"
                                >
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="td-empty">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <p>Belum ada user yang terdaftar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer info --}}
    @if($users->count())
    <p class="um-count">Menampilkan <strong>{{ $users->count() }}</strong> user</p>
    @endif

</div>

<style>
/* ── Layout ─────────────────────────────── */
.um-wrapper {
    max-width: 960px;
    margin: 2.5rem auto;
    padding: 0 1.25rem;
    font-family: 'Figtree', 'Segoe UI', sans-serif;
}

/* ── Header ─────────────────────────────── */
.um-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.um-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 .2rem;
    letter-spacing: -.02em;
}
.um-subtitle {
    font-size: .875rem;
    color: #6b7280;
    margin: 0;
}

/* ── Add Button ─────────────────────────── */
.um-btn-add {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: .55rem 1.1rem;
    background: #3b5bdb;
    color: #fff;
    border-radius: 10px;
    font-size: .875rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .18s, transform .15s, box-shadow .18s;
    box-shadow: 0 2px 8px rgba(59,91,219,.25);
}
.um-btn-add:hover {
    background: #2f4ac0;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(59,91,219,.32);
}
.um-btn-add:active { transform: translateY(0); }

/* ── Alert ──────────────────────────────── */
.um-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: .85rem 1.1rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    color: #166534;
    font-size: .875rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
}

/* ── Card / Table ───────────────────────── */
.um-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
}
.um-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
}
.um-table thead tr {
    background: #f8f9fb;
    border-bottom: 1px solid #e5e7eb;
}
.um-table th {
    padding: .8rem 1.1rem;
    text-align: left;
    font-size: .75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .05em;
    white-space: nowrap;
}
.um-table td {
    padding: .85rem 1.1rem;
    color: #374151;
    vertical-align: middle;
    border-bottom: 1px solid #f3f4f6;
}
.um-table tbody tr:last-child td { border-bottom: none; }
.um-table tbody tr {
    transition: background .14s;
}
.um-table tbody tr:hover { background: #fafbff; }

/* ── Avatar + Name ──────────────────────── */
.um-avatar-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.um-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #3b5bdb);
    color: #fff;
    font-size: .8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.um-name { font-weight: 600; color: #111827; }

/* ── Cells ──────────────────────────────── */
.td-no { color: #9ca3af; font-variant-numeric: tabular-nums; text-align: center; }
.td-email { color: #6b7280; font-family: monospace; font-size: .82rem; }

/* ── Badge ──────────────────────────────── */
.um-badge {
    display: inline-block;
    padding: .2rem .75rem;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 600;
    white-space: nowrap;
}

/* ── Action Buttons ─────────────────────── */
.um-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}
.um-btn-edit, .um-btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: .35rem .7rem;
    border-radius: 8px;
    font-size: .8rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .12s;
    border: 1px solid transparent;
    white-space: nowrap;
}
.um-btn-edit {
    background: #f0f9ff;
    color: #0369a1;
    border-color: #bae6fd;
}
.um-btn-edit:hover { background: #e0f2fe; }

.um-btn-delete {
    background: #fff5f5;
    color: #c0392b;
    border-color: #fecaca;
}
.um-btn-delete:hover { background: #fee2e2; }
.um-btn-edit:active, .um-btn-delete:active { transform: scale(.96); }

/* ── Empty state ────────────────────────── */
.td-empty {
    text-align: center;
    padding: 3rem 1rem !important;
    color: #9ca3af;
}
.td-empty svg { margin: 0 auto 10px; display: block; opacity: .45; }
.td-empty p { margin: 0; font-size: .9rem; }

/* ── Footer count ───────────────────────── */
.um-count {
    margin-top: .85rem;
    font-size: .8rem;
    color: #9ca3af;
    text-align: right;
}
.um-count strong { color: #6b7280; }

/* ── Responsive ─────────────────────────── */
@media (max-width: 600px) {
    .td-email { display: none; }
    .um-table th:nth-child(3), .um-table td:nth-child(3) { display: none; }
}
</style>
@endsection