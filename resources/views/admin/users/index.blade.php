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
                            
                            {{-- Form Delete dengan Trigger Modal --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="form-delete-user" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="button" 
                                    class="um-btn-delete btn-delete-trigger" 
                                    data-name="{{ $user->name }}"
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


</div>

{{-- Modal Konfirmasi Delete --}}
<div id="deleteModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="modal-title">Hapus Pengguna?</h3>
        <p class="modal-text">Apakah Anda yakin ingin menghapus <strong id="userNameTarget"></strong>? Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" id="closeModal">Batal</button>
            <button type="button" class="btn-confirm-delete" id="confirmDeleteBtn">Ya, Hapus</button>
        </div>
    </div>
</div>

<style>
/* ── Layout & Typography ─────────────────── */
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

/* ── Buttons ────────────────────────────── */
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
    transition: all .18s;
    box-shadow: 0 2px 8px rgba(59,91,219,.25);
}
.um-btn-add:hover {
    background: #2f4ac0;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(59,91,219,.32);
}

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

/* ── Table & Card ───────────────────────── */
.um-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.04);
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
}
.um-table td {
    padding: .85rem 1.1rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
}
.um-table tbody tr:hover { background: #fafbff; }

/* ── Avatar & Badges ────────────────────── */
.um-avatar-row { display: flex; align-items: center; gap: 10px; }
.um-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #3b5bdb);
    color: #fff; font-size: .8rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
.um-name { font-weight: 600; color: #111827; }
.um-badge {
    padding: .2rem .75rem; background: #eff6ff; color: #1d4ed8;
    border: 1px solid #bfdbfe; border-radius: 999px;
    font-size: .75rem; font-weight: 600;
}

/* ── Action Buttons ─────────────────────── */
.um-actions { display: flex; align-items: center; gap: 6px; }
.um-btn-edit, .um-btn-delete {
    display: inline-flex; align-items: center; gap: 5px;
    padding: .35rem .7rem; border-radius: 8px; font-size: .8rem;
    font-weight: 600; cursor: pointer; text-decoration: none;
    transition: all .15s; border: 1px solid transparent;
}
.um-btn-edit { background: #f0f9ff; color: #0369a1; border-color: #bae6fd; }
.um-btn-edit:hover { background: #e0f2fe; }
.um-btn-delete { background: #fff5f5; color: #c0392b; border-color: #fecaca; }
.um-btn-delete:hover { background: #fee2e2; }

/* ── CUSTOM MODAL DELETE STYLES ─────────── */
.modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.6); /* Overlay gelap sedikit biru */
    backdrop-filter: blur(4px);
    display: none; align-items: center; justify-content: center;
    z-index: 9999; animation: fadeIn 0.2s ease-out;
}
.modal-content {
    background: #fff; padding: 1.75rem; border-radius: 20px;
    width: 90%; max-width: 400px; text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    transform: scale(0.9); transition: transform 0.2s ease-out;
}
.modal-overlay.active { display: flex; }
.modal-overlay.active .modal-content { transform: scale(1); }

.modal-icon {
    width: 60px; height: 60px; background: #fee2e2;
    border-radius: 50%; display: flex; align-items: center;
    justify-content: center; margin: 0 auto 1.25rem;
}
.modal-title { font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem; }
.modal-text { font-size: 0.95rem; color: #6b7280; line-height: 1.5; margin-bottom: 1.75rem; }

.modal-footer { display: flex; gap: 12px; }
.modal-footer button {
    flex: 1; padding: 0.75rem; border-radius: 12px;
    font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.15s; border: none;
}
.btn-cancel { background: #f3f4f6; color: #4b5563; }
.btn-cancel:hover { background: #e5e7eb; }
.btn-confirm-delete { background: #ef4444; color: #fff; }
.btn-confirm-delete:hover { background: #dc2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

/* ── Responsive ─────────────────────────── */
@media (max-width: 600px) {
    .td-email { display: none; }
    .um-table th:nth-child(3), .um-table td:nth-child(3) { display: none; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteModal');
    const closeModal = document.getElementById('closeModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const userNameTarget = document.getElementById('userNameTarget');
    let currentForm = null;

    // Trigger Modal saat tombol hapus diklik
    document.querySelectorAll('.btn-delete-trigger').forEach(button => {
        button.addEventListener('click', function() {
            currentForm = this.closest('form');
            const name = this.getAttribute('data-name');
            
            userNameTarget.textContent = name; // Tampilkan nama di modal
            modal.classList.add('active'); // Munculkan modal
        });
    });

    // Tutup Modal
    closeModal.addEventListener('click', () => {
        modal.classList.remove('active');
        currentForm = null;
    });

    // Eksekusi Submit Form setelah dikonfirmasi
    confirmDeleteBtn.addEventListener('click', () => {
        if (currentForm) {
            confirmDeleteBtn.innerHTML = 'Menghapus...'; // Feedback visual
            confirmDeleteBtn.style.opacity = '0.7';
            currentForm.submit();
        }
    });

    // Tutup jika klik di area luar modal (overlay)
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
});
</script>
@endsection