@extends('layouts.master')

@section('content')
<div class="db-wrapper">
    <div class="db-inner">

        {{-- TOP BAR --}}
        <div class="db-topbar">
            <div>
                <h2 class="db-title">Dashboard Admin</h2>
                <p class="db-greeting">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> 👋</p>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="db-stats">

            <div class="db-stat-card">
                <div class="db-stat-icon db-stat-icon--blue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="db-stat-body">
                    <p class="db-stat-label">Total User</p>
                    <p class="db-stat-value">{{ $totalUsers }}</p>
                </div>
                <div class="db-stat-trend">
                    <svg width="32" height="18" viewBox="0 0 32 18" fill="none"><polyline points="0,16 10,8 20,12 32,2" stroke="#3b5bdb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity=".35"/></svg>
                </div>
            </div>

            <div class="db-stat-card">
                <div class="db-stat-icon db-stat-icon--emerald">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="db-stat-body">
                    <p class="db-stat-label">Total Event</p>
                    <p class="db-stat-value">{{ $totalEvents }}</p>
                </div>
                <div class="db-stat-trend">
                    <svg width="32" height="18" viewBox="0 0 32 18" fill="none"><polyline points="0,14 8,10 18,6 32,2" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity=".35"/></svg>
                </div>
            </div>

        </div>

        {{-- LATEST EVENTS --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-title-wrap">
                    <span class="db-card-dot"></span>
                    <h5 class="db-card-title">Event Terbaru</h5>
                </div>
                <span class="db-badge-count">{{ $latestEvents->count() }} event</span>
            </div>

            <table class="db-table">
                <thead>
                    <tr>
                        <th>Nama Event</th>
                        <th>Tanggal</th>
                        <th style="width:36px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestEvents as $event)
                    <tr>
                        <td>
                            <div class="db-event-name">
                                <span class="db-event-dot"></span>
                                {{ $event->title }}
                            </div>
                        </td>
                        <td class="db-td-date">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="opacity:.45;vertical-align:middle;margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $event->event_date }}
                        </td>
                        <td>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color:#d1d5db;"><polyline points="9 18 15 12 9 6"/></svg>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="db-empty">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <p>Belum ada event yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
.db-wrapper {
    background: #f5f6fa;
    min-height: 100vh;
    padding: 2rem 1.25rem 3rem;
    font-family: 'Figtree', 'Segoe UI', sans-serif;
}
.db-inner { max-width: 860px; margin: 0 auto; }

/* Topbar */
.db-topbar {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.db-title { font-size: 1.45rem; font-weight: 700; color: #111827; margin: 0 0 .2rem; letter-spacing: -.02em; }
.db-greeting { font-size: .875rem; color: #6b7280; margin: 0; }
.db-greeting strong { color: #374151; font-weight: 600; }

.db-btn-logout {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: .5rem 1rem;
    background: #fff5f5;
    color: #c0392b;
    border: 1px solid #fecaca;
    border-radius: 10px;
    font-size: .84rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s;
}
.db-btn-logout:hover { background: #fee2e2; }

/* Stat cards */
.db-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.4rem;
}
.db-stat-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.25rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 14px rgba(0,0,0,.04);
    position: relative;
    overflow: hidden;
}
.db-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.db-stat-icon--blue { background: #eff6ff; color: #3b5bdb; }
.db-stat-icon--emerald { background: #ecfdf5; color: #10b981; }
.db-stat-body { flex: 1; min-width: 0; }
.db-stat-label { font-size: .75rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin: 0 0 4px; }
.db-stat-value { font-size: 1.9rem; font-weight: 700; color: #111827; margin: 0; line-height: 1; letter-spacing: -.03em; }
.db-stat-trend { flex-shrink: 0; opacity: .6; }

/* Card */
.db-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    margin-bottom: 1.4rem;
}
.db-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.1rem 1.4rem;
    border-bottom: 1px solid #f3f4f6;
}
.db-card-title-wrap { display: flex; align-items: center; gap: 8px; }
.db-card-dot { width: 8px; height: 8px; border-radius: 50%; background: #3b5bdb; display: inline-block; }
.db-card-title { font-size: .95rem; font-weight: 700; color: #111827; margin: 0; }
.db-badge-count {
    font-size: .72rem;
    font-weight: 600;
    color: #6b7280;
    background: #f3f4f6;
    border-radius: 999px;
    padding: .2rem .65rem;
}

/* Table */
.db-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.db-table thead tr { background: #fafafa; }
.db-table th {
    padding: .7rem 1.4rem;
    text-align: left;
    font-size: .72rem;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.db-table td {
    padding: .85rem 1.4rem;
    color: #374151;
    border-top: 1px solid #f3f4f6;
    vertical-align: middle;
}
.db-table tbody tr { transition: background .13s; }
.db-table tbody tr:hover { background: #fafbff; }

.db-event-name {
    display: flex;
    align-items: center;
    gap: 9px;
    font-weight: 600;
    color: #111827;
}
.db-event-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #3b5bdb;
    flex-shrink: 0;
    opacity: .5;
}
.db-td-date { color: #6b7280; font-size: .83rem; white-space: nowrap; }

/* Empty */
.db-empty {
    text-align: center;
    padding: 3rem 1rem !important;
    color: #9ca3af;
}
.db-empty svg { margin: 0 auto 10px; display: block; opacity: .35; }
.db-empty p { margin: 0; font-size: .875rem; }
</style>

@endsection

@section("ExtraCSS")
@endsection

@section("ExtraJS")
@endsection