@extends('layouts.master')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

  :root {
    --bg: #ffffff;
    --surface: #FFFFFF;
    --surface-2: #F9F8F5;
    --border: rgba(0,0,0,0.07);
    --text-primary: #1A1917;
    --text-secondary: #6B6860;
    --text-muted: #A8A49E;
    --green: #1D9E75;
    --green-bg: #E3F5EE;
    --green-text: #0A5E41;
    --blue: #2E7DD1;
    --blue-bg: #E4EFF9;
    --blue-text: #1145A0;
    --amber: #C98A10;
    --amber-bg: #FEF3DC;
    --amber-text: #7A4F00;
    --red: #D94040;
    --red-bg: #FDECEC;
    --red-text: #8A1818;
    --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
    --radius: 16px;
    --radius-sm: 10px;
  }

  .ud-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 32px 56px;
    background: var(--bg);
    min-height: 100vh;
    color: var(--text-primary);
  }

  /* ─── Welcome Banner ─── */
  .ud-welcome {
    background: var(--text-primary);
    border-radius: var(--radius);
    padding: 28px 32px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    position: relative;
    overflow: hidden;
  }
  .ud-welcome::before {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(40, 2, 255, 0.04);
  }
  .ud-welcome::after {
    content: '';
    position: absolute;
    right: 60px; bottom: -60px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.03);
  }
  .ud-welcome-text h2 {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -.3px;
  }
  .ud-welcome-text p {
    font-size: 13px;
    color: rgba(255,255,255,0.5);
    margin: 0;
    max-width: 420px;
    line-height: 1.6;
  }
  .ud-welcome-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
  }
  .uw-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    padding: 9px 18px;
    border-radius: 99px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity .15s, transform .15s;
    white-space: nowrap;
  }
  .uw-btn:hover { opacity: .85; transform: translateY(-1px); text-decoration: none; }
  .uw-btn-white { background: #fff; color: var(--text-primary); }
  .uw-btn-ghost { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,.15); }

  /* ─── Stats Grid ─── */
  .ud-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 20px;
  }
  @media (max-width: 768px) { .ud-stats { grid-template-columns: 1fr; } }

  .ud-stat {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 22px;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: box-shadow .2s, transform .2s;
  }
  .ud-stat:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
  .ud-stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .ud-stat-info { flex: 1; min-width: 0; }
  .ud-stat-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-muted);
    margin-bottom: 5px;
  }
  .ud-stat-value {
    font-size: 26px;
    font-weight: 700;
    letter-spacing: -.6px;
    line-height: 1;
    font-family: 'DM Mono', monospace;
    margin-bottom: 4px;
  }
  .ud-stat-foot { font-size: 11.5px; color: var(--text-muted); }

  /* ─── Table Card ─── */
  .ud-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .ud-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid var(--border);
    background: var(--surface-2);
  }
  .ud-card-head-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .ud-card-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: #ffffff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .ud-card-title {
    font-size: 14px;
    font-weight: 700;
    letter-spacing: -.1px;
    margin: 0;
  }
  .ud-count-chip {
    background: #EEECEA;
    border: 1px solid var(--border);
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 600;
    padding: 3px 11px;
    border-radius: 99px;
    font-family: 'DM Mono', monospace;
  }

  /* ─── Table ─── */
  .ud-table { width: 100%; border-collapse: separate; border-spacing: 0; }
  .ud-table thead th {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-muted);
    padding: 12px 22px;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
    background: var(--surface);
  }
  .ud-table tbody tr { transition: background .12s; }
  .ud-table tbody tr:hover td { background: var(--surface-2); }
  .ud-table tbody td {
    padding: 14px 22px;
    font-size: 13.5px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }
  .ud-table tbody tr:last-child td { border-bottom: none; }

  .td-event-title { font-weight: 600; font-size: 13.5px; margin: 0 0 3px; }
  .td-event-ref { font-size: 11.5px; color: var(--text-muted); font-family: 'DM Mono', monospace; }
  .td-ticket { font-size: 13px; color: var(--text-secondary); }
  .td-amount { font-family: 'DM Mono', monospace; font-size: 13px; font-weight: 600; color: var(--green-text); }
  .td-date { font-size: 12.5px; color: var(--text-muted); font-family: 'DM Mono', monospace; }

  /* Status Badges */
  .s-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 11px;
    border-radius: 99px;
    white-space: nowrap;
    letter-spacing: .01em;
  }
  .s-badge::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  .s-paid { background: var(--green-bg); color: var(--green-text); }
  .s-paid::before { background: var(--green); }
  .s-pending { background: var(--amber-bg); color: var(--amber-text); }
  .s-pending::before { background: var(--amber); }
  .s-cancelled { background: var(--red-bg); color: var(--red-text); }
  .s-cancelled::before { background: var(--red); }

  /* Empty State */
  .ud-empty {
    text-align: center;
    padding: 52px 24px;
  }
  .ud-empty-icon {
    width: 50px; height: 50px;
    background: #EEECEA;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }
  .ud-empty h3 { font-size: 15px; font-weight: 700; margin: 0 0 5px; }
  .ud-empty p { font-size: 13px; color: var(--text-muted); margin: 0 0 16px; }
  .ud-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--text-primary);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 99px;
    text-decoration: none;
    transition: opacity .15s;
  }
  .ud-empty-btn:hover { opacity: .82; color: #fff; text-decoration: none; }
</style>

<div class="ud-wrap">7

  {{-- Welcome Banner --}}
  <div class="ud-welcome">
    <div class="ud-welcome-text">
      <h2>Selamat datang, {{ Auth::user()->name }}! 👋</h2>
      <p>Kelola event, lihat registrasi, dan cek status pembayaran Anda di sini.</p>
    </div>
    <div class="ud-welcome-actions">
      <a href="{{ route('user.events.index') }}" class="uw-btn uw-btn-white">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Cari Event
      </a>
      <a href="{{ route('user.events.history') }}" class="uw-btn uw-btn-ghost">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
        Riwayat
      </a>
      <a href="{{ route('user.payment.history') }}" class="uw-btn uw-btn-ghost">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        Pembayaran
      </a>
    </div>
  </div>

  {{-- Stats --}}
  <div class="ud-stats">

    <div class="ud-stat">
      <div class="ud-stat-icon" style="background:var(--blue-bg)">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1145A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </div>
      <div class="ud-stat-info">
        <div class="ud-stat-label">Total Event</div>
        <div class="ud-stat-value" style="color:var(--blue-text)">{{ $registrations->count() }}</div>
        <div class="ud-stat-foot">Event yang terdaftar</div>
      </div>
    </div>

    <div class="ud-stat">
      <div class="ud-stat-icon" style="background:var(--amber-bg)">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7A4F00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div class="ud-stat-info">
        <div class="ud-stat-label">Pending</div>
        <div class="ud-stat-value" style="color:var(--amber-text)">{{ $registrations->filter(fn($r) => $r->status === 'pending')->count() }}</div>
        <div class="ud-stat-foot">Menunggu Approval oragnizer</div>
      </div>
    </div>

    <div class="ud-stat">
      <div class="ud-stat-icon" style="background:var(--green-bg)">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0A5E41" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div class="ud-stat-info">
        <div class="ud-stat-label">Confirmed</div>
        <div class="ud-stat-value" style="color:var(--green-text)">{{ $registrations->filter(fn($r) => $r->status === 'paid')->count() }}</div>
        <div class="ud-stat-foot">Event terkonfirmasi</div>
      </div>
    </div>

  </div>

  {{-- Recent Registrations --}}
  <div class="ud-card">
    <div class="ud-card-head">
      <div class="ud-card-head-left">
        <div class="ud-card-icon">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1A1917" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        </div>
        <p class="ud-card-title">Registrasi Terbaru</p>
      </div>
      <span class="ud-count-chip">{{ $registrations->take(10)->count() }} item</span>
    </div>

    <div class="table-responsive">
      <table class="ud-table">
        <thead>
          <tr>
            <th>Event</th>
            <th>Tiket</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Tanggal Daftar</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($registrations->take(10) as $reg)
            <tr>
              <td>
                <p class="td-event-title">{{ Str::limit($reg->event->title, 30) }}</p>
                <span class="td-event-ref">{{ $reg->payment_reference }}</span>
              </td>
              <td class="td-ticket">
                @foreach ($reg->orderItems as $item)
                  {{ $item->ticketType->name }}<br>
                @endforeach
              </td>
              <td class="td-amount">Rp {{ number_format($reg->total_amount, 0, ',', '.') }}</td>
              <td>
                @if ($reg->status === 'paid')
                  <span class="s-badge s-paid">Confirmed</span>
                @elseif ($reg->status === 'pending')
                  <span class="s-badge s-pending">pending</span>
                @else
                  <span class="s-badge s-cancelled">Rejected</span>
                @endif
              </td>
              <td class="td-date">{{ $reg->created_at->format('d M Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5">
                <div class="ud-empty">
                  <div class="ud-empty-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#A8A49E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                  </div>
                  <h3>Belum ada registrasi</h3>
                  <p>Temukan dan daftar event menarik di sekitar Anda</p>
                  <a href="{{ route('user.events.index') }}" class="ud-empty-btn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Jelajahi Event
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection

@section("ExtraCSS")
@endsection

@section("ExtraJS")
@endsection