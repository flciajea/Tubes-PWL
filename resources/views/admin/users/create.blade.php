@extends('layouts.master')

@section('content')
<div class="cu-wrapper">
    <div class="cu-inner">

        {{-- HEADER --}}
        <div class="cu-header">
            <div>
                <h2 class="cu-title">Tambah User</h2>
                <p class="cu-subtitle">Buat akun pengguna baru dan tentukan aksesnya</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="cu-btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>

        {{-- CARD --}}
        <div class="cu-card">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                {{-- NAMA --}}
                <div class="cu-field">
                    <label class="cu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Nama
                    </label>
                    <input type="text" name="name"
                        class="cu-input @error('name') cu-input-error @enderror"
                        placeholder="Nama lengkap"
                        value="{{ old('name') }}"
                        required>
                    @error('name')
                        <span class="cu-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="cu-field">
                    <label class="cu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email
                    </label>
                    <input type="email" name="email"
                        class="cu-input @error('email') cu-input-error @enderror"
                        placeholder="email@contoh.com"
                        value="{{ old('email') }}"
                        required>
                    @error('email')
                        <span class="cu-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- DIVIDER --}}
                <div class="cu-divider"><span>Keamanan Akun</span></div>

                {{-- PASSWORD --}}
                <div class="cu-field">
                    <label class="cu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Password
                    </label>
                    <div class="cu-pw-wrap">
                        <input type="password" name="password" id="pw1"
                            class="cu-input @error('password') cu-input-error @enderror"
                            placeholder="Minimal 8 karakter"
                            required>
                        <button type="button" class="cu-pw-toggle" onclick="togglePw('pw1', this)" aria-label="Toggle password">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="cu-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="cu-field">
                    <label class="cu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Confirm Password
                    </label>
                    <div class="cu-pw-wrap">
                        <input type="password" name="password_confirmation" id="pw2"
                            class="cu-input"
                            placeholder="Ulangi password"
                            required>
                        <button type="button" class="cu-pw-toggle" onclick="togglePw('pw2', this)" aria-label="Toggle confirm password">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="cu-divider"><span>Hak Akses</span></div>

                {{-- ROLE --}}
                <div class="cu-field">
                    <label class="cu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Role
                    </label>
                    <div class="cu-select-wrap">
                        <select name="role_id" class="cu-input cu-select" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <svg class="cu-select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="cu-actions">
                    <button type="submit" class="cu-btn-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="cu-btn-cancel">Batal</a>
                </div>

            </form>
        </div>

    </div>
</div>

<style>
.cu-wrapper {
    background: #f5f6fa;
    min-height: 100vh;
    padding: 2rem 1.25rem 3rem;
    font-family: 'Figtree', 'Segoe UI', sans-serif;
}
.cu-inner { max-width: 560px; margin: 0 auto; }

.cu-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.cu-title { font-size: 1.4rem; font-weight: 700; color: #111827; margin: 0 0 .2rem; letter-spacing: -.02em; }
.cu-subtitle { font-size: .85rem; color: #6b7280; margin: 0; }

.cu-btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: .48rem .95rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: .84rem;
    font-weight: 600;
    color: #374151;
    text-decoration: none;
    transition: background .15s;
    white-space: nowrap;
}
.cu-btn-back:hover { background: #f9fafb; color: #111827; }

.cu-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 1.75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 6px 20px rgba(0,0,0,.05);
}

.cu-field { margin-bottom: 1.1rem; }
.cu-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .42rem;
}
.cu-input {
    width: 100%;
    padding: .62rem .9rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: .875rem;
    color: #111827;
    background: #fff;
    box-sizing: border-box;
    outline: none;
    font-family: inherit;
    transition: border-color .18s, box-shadow .18s;
    appearance: none;
    -webkit-appearance: none;
}
.cu-input:focus { border-color: #3b5bdb; box-shadow: 0 0 0 3px rgba(59,91,219,.11); }
.cu-input::placeholder { color: #9ca3af; }
.cu-input-error { border-color: #ef4444 !important; }

.cu-pw-wrap { position: relative; }
.cu-pw-wrap .cu-input { padding-right: 2.6rem; }
.cu-pw-toggle {
    position: absolute;
    right: .7rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    padding: 0;
    display: flex;
    align-items: center;
    transition: color .15s;
}
.cu-pw-toggle:hover { color: #374151; }

.cu-select-wrap { position: relative; }
.cu-select { padding-right: 2.4rem; cursor: pointer; }
.cu-select-arrow {
    position: absolute;
    right: .75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
}

.cu-error {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: .38rem;
    font-size: .77rem;
    color: #dc2626;
    font-weight: 500;
}

.cu-divider {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin: 1.4rem 0 1.2rem;
    color: #9ca3af;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
}
.cu-divider::before,
.cu-divider::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }

.cu-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-top: 1.6rem;
    padding-top: 1.4rem;
    border-top: 1px solid #f3f4f6;
}
.cu-btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: .65rem 1.35rem;
    background: #3b5bdb;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background .18s, transform .15s, box-shadow .18s;
    box-shadow: 0 2px 8px rgba(59,91,219,.28);
}
.cu-btn-submit:hover { background: #2f4ac0; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(59,91,219,.34); }
.cu-btn-submit:active { transform: scale(.97); }

.cu-btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: .65rem 1.05rem;
    background: transparent;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: .875rem;
    font-weight: 500;
    text-decoration: none;
    transition: background .15s, color .15s;
}
.cu-btn-cancel:hover { background: #f9fafb; color: #374151; }
</style>

@endsection

@section('ExtraJS')
<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.style.color = isHidden ? '#3b5bdb' : '#9ca3af';
}
</script>
@endsection