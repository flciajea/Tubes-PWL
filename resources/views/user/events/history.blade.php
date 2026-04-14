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

  .eh-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 32px 56px;
    background: var(--bg);
    min-height: 100vh;
    color: var(--text-primary);
  }

  /* ─── Header ─── */
  .eh-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 22px;
  }
  .eh-header h1 {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -.4px;
    margin: 0 0 4px;
  }
  .eh-header p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
  }
  .eh-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    background: var(--surface);
    border: 1px solid var(--border);
    padding: 8px 16px;
    border-radius: 99px;
    text-decoration: none;
    transition: background .15s, color .15s;
  }
  .eh-back:hover { background: #ffffff; color: var(--text-primary); text-decoration: none; }

  /* ─── Alert ─── */
  .eh-alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--green-bg);
    border: 1px solid rgba(29,158,117,.2);
    border-radius: var(--radius-sm);
    padding: 13px 16px;
    margin-bottom: 18px;
    font-size: 13.5px;
    color: var(--green-text);
    font-weight: 500;
  }
  .eh-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--green-text);
    opacity: .6;
    padding: 0;
    line-height: 1;
  }
  .eh-alert-close:hover { opacity: 1; }

  /* ─── Card ─── */
  .eh-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .eh-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid var(--border);
    background: var(--surface-2);
  }
  .eh-card-head-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .eh-card-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: #EEECEA;
    display: flex; align-items: center; justify-content: center;
  }
  .eh-card-title {
    font-size: 14px;
    font-weight: 700;
    letter-spacing: -.1px;
    margin: 0;
  }
  .eh-count-chip {
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
  .eh-table { width: 100%; border-collapse: separate; border-spacing: 0; }
  .eh-table thead th {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-muted);
    padding: 12px 20px;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
    background: var(--surface);
  }
  .eh-table thead th.th-center { text-align: center; }
  .eh-table tbody tr { transition: background .12s; }
  .eh-table tbody tr:hover td { background: var(--surface-2); }
  .eh-table tbody td {
    padding: 14px 20px;
    font-size: 13.5px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }
  .eh-table tbody tr:last-child td { border-bottom: none; }

  .td-no {
    font-family: 'DM Mono', monospace;
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    width: 44px;
  }
  .td-event-title { font-weight: 600; font-size: 13.5px; margin: 0 0 3px; }
  .td-event-ref { font-size: 11.5px; color: var(--text-muted); font-family: 'DM Mono', monospace; }
  .td-ticket { font-size: 13px; color: var(--text-secondary); line-height: 1.6; }
  .td-qty { font-family: 'DM Mono', monospace; font-size: 13px; color: var(--text-secondary); text-align: center; }
  .td-amount { font-family: 'DM Mono', monospace; font-size: 13px; font-weight: 600; color: var(--green-text); }
  .td-date { font-family: 'DM Mono', monospace; font-size: 12px; color: var(--text-muted); }

  /* ─── Status Badges ─── */
  .s-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 11px;
    border-radius: 99px;
    white-space: nowrap;
  }
  .s-badge::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  .s-paid    { background: var(--green-bg); color: var(--green-text); }
  .s-paid::before { background: var(--green); }
  .s-pending { background: var(--amber-bg); color: var(--amber-text); }
  .s-pending::before { background: var(--amber); animation: blink 1.6s ease infinite; }
  .s-cancelled { background: var(--red-bg); color: var(--red-text); }
  .s-cancelled::before { background: var(--red); }
  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

  /* ─── Empty State ─── */
  .eh-empty {
    text-align: center;
    padding: 60px 24px;
  }
  .eh-empty-icon {
    width: 52px; height: 52px;
    background: #EEECEA;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
  }
  .eh-empty h3 { font-size: 16px; font-weight: 700; margin: 0 0 6px; letter-spacing: -.2px; }
  .eh-empty p { font-size: 13px; color: var(--text-muted); margin: 0; }

  /* ─── Pagination ─── */
  .eh-pagination {
    display: flex;
    justify-content: flex-end;
    padding: 16px 22px;
    border-top: 1px solid var(--border);
  }
  /* Override default Laravel pagination to match theme */
  .eh-pagination nav .flex { gap: 4px; }
  .eh-pagination nav span[aria-current="page"] > span,
  .eh-pagination nav a {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px !important;
    border: 1px solid var(--border) !important;
    color: var(--text-secondary) !important;
    padding: 6px 12px !important;
    line-height: 1.4 !important;
  }
  .eh-pagination nav span[aria-current="page"] > span {
    background: var(--text-primary) !important;
    color: #fff !important;
    border-color: var(--text-primary) !important;
  }
  .eh-pagination nav a:hover {
    background: #EEECEA !important;
    color: var(--text-primary) !important;
  }
</style>

<div class="eh-wrap">

  {{-- Header --}}
  <div class="eh-header">
    <div>
      <h1>Riwayat Event</h1>
      <p>Semua pendaftaran event yang pernah Anda lakukan</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="eh-back">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      Dashboard
    </a>
  </div>

  {{-- Alert --}}
  @if (session('success'))
    <div class="eh-alert-success" role="alert" id="successAlert">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
      <button class="eh-alert-close" onclick="document.getElementById('successAlert').remove()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  @endif

  {{-- Table Card --}}
  <div class="eh-card">
    <div class="eh-card-head">
      <div class="eh-card-head-left">
        <div class="eh-card-icon">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1A1917" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
        </div>
        <p class="eh-card-title">Riwayat Pendaftaran</p>
      </div>
      <span class="eh-count-chip">{{ $registrations->total() }} total</span>
    </div>

    <div class="table-responsive">
      <table class="eh-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Event</th>
            <th>Tiket</th>
            <th class="th-center">Qty</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Tanggal Event</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($registrations as $reg)
            <tr>
              <td class="td-no">{{ str_pad(($registrations->currentPage() - 1) * $registrations->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
              <td>
                <p class="td-event-title">{{ Str::limit($reg->event->title, 30) }}</p>
                <span class="td-event-ref">{{ $reg->payment_reference }}</span>
              </td>
              <td class="td-ticket">
                @foreach ($reg->orderItems as $item)
                  {{ $item->ticketType->name }}<br>
                @endforeach
              </td>
              <td class="td-qty">
                @foreach ($reg->orderItems as $item)
                  {{ $item->quantity }}<br>
                @endforeach
              </td>
              <td class="td-amount">Rp {{ number_format($reg->total_amount, 0, ',', '.') }}</td>
              <td>
                @if ($reg->status === 'paid')
                  <span class="s-badge s-paid">Confirmed</span>
                @elseif ($reg->status === 'pending')
                  <span class="s-badge s-pending">Waiting Approval From Organizer</span>
                @else
                  <span class="s-badge s-cancelled">Rejected</span>
                @endif
              </td>
              <td class="td-date">{{ $reg->event->event_date->format('d M Y H:i') }}</td>
              <td></td>
            </tr>
          @empty
            <tr>
              <td colspan="8">
                <div class="eh-empty">
                  <div class="eh-empty-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#A8A49E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                  </div>
                  <h3>Belum ada riwayat</h3>
                  <p>Anda belum pernah mendaftar ke event apapun</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($registrations->count() > 0)
      <div class="eh-pagination">
        {{ $registrations->links() }}
      </div>
    @endif

  </div>

</div>

@endsection

@section('ExtraJS')
@endsection