@extends('layouts.master')

@section('content')
<div class="eu-wrapper">
    <div class="eu-inner">

        {{-- HEADER --}}
        <div class="eu-header">
            <div>
                <h2 class="eu-title">Edit User</h2>
                <p class="eu-subtitle">Perbarui informasi akun <strong>{{ $user->name }}</strong></p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="eu-btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>

        {{-- AVATAR BADGE --}}
        <div class="eu-user-badge">
            <div class="eu-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
            <div>
                <p class="eu-badge-name">{{ $user->name }}</p>
                <p class="eu-badge-email">{{ $user->email }}</p>
            </div>
            <span class="eu-role-pill">{{ $user->role->name ?? '-' }}</span>
        </div>

        {{-- CARD --}}
        <div class="eu-card">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAMA --}}
                <div class="eu-field">
                    <label class="eu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Nama
                    </label>
                    <input type="text" name="name"
                        class="eu-input @error('name') eu-input-error @enderror"
                        value="{{ old('name', $user->name) }}"
                        required>
                    @error('name')
                        <span class="eu-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="eu-field">
                    <label class="eu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email
                    </label>
                    <input type="email" name="email"
                        class="eu-input @error('email') eu-input-error @enderror"
                        value="{{ old('email', $user->email) }}"
                        required>
                    @error('email')
                        <span class="eu-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- DIVIDER --}}
                <div class="eu-divider"><span>Hak Akses</span></div>

                {{-- ROLE --}}
                <div class="eu-field">
                    <label class="eu-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Role
                    </label>
                    <div class="eu-select-wrap">
                        <select name="role_id" class="eu-input eu-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="eu-select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="eu-actions">
                    <button type="submit" class="eu-btn-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="eu-btn-cancel">Batal</a>
                </div>

            </form>
        </div>

    </div>
</div>

<style>
.eu-wrapper {
    background: #f5f6fa;
    min-height: 100vh;
    padding: 2rem 1.25rem 3rem;
    font-family: 'Figtree', 'Segoe UI', sans-serif;
}
.eu-inner { max-width: 560px; margin: 0 auto; }

/* Header */
.eu-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.25rem;
}
.eu-title { font-size: 1.4rem; font-weight: 700; color: #111827; margin: 0 0 .2rem; letter-spacing: -.02em; }
.eu-subtitle { font-size: .85rem; color: #6b7280; margin: 0; }
.eu-subtitle strong { color: #374151; font-weight: 600; }

.eu-btn-back {
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
.eu-btn-back:hover { background: #f9fafb; color: #111827; }

/* User badge */
.eu-user-badge {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: .9rem 1.2rem;
    margin-bottom: 1.2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.eu-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #3b5bdb);
    color: #fff;
    font-size: .85rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    letter-spacing: .02em;
}
.eu-badge-name { font-size: .9rem; font-weight: 700; color: #111827; margin: 0 0 2px; }
.eu-badge-email { font-size: .78rem; color: #9ca3af; margin: 0; font-family: monospace; }
.eu-role-pill {
    margin-left: auto;
    padding: .25rem .8rem;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 600;
    white-space: nowrap;
}

/* Card */
.eu-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 1.75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 6px 20px rgba(0,0,0,.05);
}

/* Fields */
.eu-field { margin-bottom: 1.1rem; }
.eu-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .42rem;
}
.eu-optional {
    margin-left: auto;
    font-size: .7rem;
    font-weight: 500;
    color: #9ca3af;
    background: #f3f4f6;
    padding: .1rem .5rem;
    border-radius: 6px;
}
.eu-input {
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
.eu-input:focus { border-color: #3b5bdb; box-shadow: 0 0 0 3px rgba(59,91,219,.11); }
.eu-input::placeholder { color: #9ca3af; }
.eu-input-error { border-color: #ef4444 !important; }

/* Password */
.eu-pw-wrap { position: relative; }
.eu-pw-wrap .eu-input { padding-right: 2.6rem; }
.eu-pw-toggle {
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
.eu-pw-toggle:hover { color: #374151; }

/* Select */
.eu-select-wrap { position: relative; }
.eu-select { padding-right: 2.4rem; cursor: pointer; }
.eu-select-arrow {
    position: absolute;
    right: .75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
}

/* Hint & Error */
.eu-hint { font-size: .75rem; color: #9ca3af; margin: .35rem 0 0; }
.eu-error {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: .38rem;
    font-size: .77rem;
    color: #dc2626;
    font-weight: 500;
}

/* Divider */
.eu-divider {
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
.eu-divider::before,
.eu-divider::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }

/* Actions */
.eu-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-top: 1.6rem;
    padding-top: 1.4rem;
    border-top: 1px solid #f3f4f6;
}
.eu-btn-submit {
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
.eu-btn-submit:hover { background: #2f4ac0; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(59,91,219,.34); }
.eu-btn-submit:active { transform: scale(.97); }
.eu-btn-cancel {
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
.eu-btn-cancel:hover { background: #f9fafb; color: #374151; }
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