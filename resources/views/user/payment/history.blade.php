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
    --blue: #2E7DD1;
    --blue-bg: #E4EFF9;
    --blue-text: #1145A0;
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

  .ph-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 32px 56px;
    background: var(--bg);
    min-height: 100vh;
    color: var(--text-primary);
  }

  /* ─── Header ─── */
  .ph-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 22px;
  }
  .ph-header h1 { font-size: 22px; font-weight: 700; letter-spacing: -.4px; margin: 0 0 4px; }
  .ph-header p  { font-size: 13px; color: var(--text-muted); margin: 0; }
  .ph-back {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 600; color: var(--text-secondary);
    background: var(--surface); border: 1px solid var(--border);
    padding: 8px 16px; border-radius: 99px; text-decoration: none;
    transition: background .15s, color .15s;
  }
  .ph-back:hover { background: #EEECEA; color: var(--text-primary); text-decoration: none; }

  /* ─── Alert ─── */
  .ph-alert {
    display: flex; align-items: flex-start; gap: 10px;
    border-radius: var(--radius-sm); padding: 13px 16px;
    margin-bottom: 18px; font-size: 13.5px; font-weight: 500;
  }
  .ph-alert.success { background: var(--green-bg); color: var(--green-text); border: 1px solid rgba(29,158,117,.2); }
  .ph-alert-close {
    margin-left: auto; background: none; border: none;
    cursor: pointer; opacity: .5; padding: 0; line-height: 1; flex-shrink: 0;
  }
  .ph-alert-close:hover { opacity: 1; }

  /* ─── Stat Grid ─── */
  .ph-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 18px;
  }
  @media (max-width: 900px) { .ph-stats { grid-template-columns: 1fr 1fr; } }
  @media (max-width: 500px) { .ph-stats { grid-template-columns: 1fr; } }

  .ph-stat {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
  }
  .ph-stat:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
  .ph-stat::after {
    content: '';
    position: absolute; top: 0; left: 0;
    width: 3px; height: 100%;
    border-radius: 3px 0 0 3px;
  }
  .ph-stat.s-all::after  { background: var(--blue); }
  .ph-stat.s-ok::after   { background: var(--green); }
  .ph-stat.s-pend::after { background: var(--amber); }
  .ph-stat.s-fail::after { background: var(--red); }

  .ph-stat-label {
    font-size: 11px; font-weight: 600; text-transform: uppercase;
    letter-spacing: .07em; margin-bottom: 8px;
  }
  .ph-stat.s-all  .ph-stat-label { color: var(--blue-text); }
  .ph-stat.s-ok   .ph-stat-label { color: var(--green-text); }
  .ph-stat.s-pend .ph-stat-label { color: var(--amber-text); }
  .ph-stat.s-fail .ph-stat-label { color: var(--red-text); }

  .ph-stat-val {
    font-family: 'DM Mono', monospace;
    font-size: 16px; font-weight: 700; letter-spacing: -.3px; line-height: 1;
  }
  .ph-stat.s-all  .ph-stat-val { color: var(--blue-text); }
  .ph-stat.s-ok   .ph-stat-val { color: var(--green-text); }
  .ph-stat.s-pend .ph-stat-val { color: var(--amber-text); }
  .ph-stat.s-fail .ph-stat-val { color: var(--red-text); }

  /* ─── Filter Bar ─── */
  .ph-filter {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 14px 20px;
    box-shadow: var(--shadow);
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
  }
  .ph-filter-label {
    font-size: 11px; font-weight: 600; text-transform: uppercase;
    letter-spacing: .07em; color: var(--text-muted); white-space: nowrap;
  }
  .ph-filter-select, .ph-filter-input {
    background: var(--surface-2); border: 1px solid var(--border);
    border-radius: var(--radius-sm); padding: 8px 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; color: var(--text-primary); outline: none;
    transition: border-color .15s, background .15s;
    appearance: none; -webkit-appearance: none;
  }
  .ph-filter-select:focus, .ph-filter-input:focus {
    border-color: #1A1917; background: #fff;
    box-shadow: 0 0 0 3px rgba(26,25,23,.07);
  }
  .ph-filter-select { padding-right: 30px; }
  .ph-filter-select-wrap { position: relative; }
  .ph-filter-select-wrap::after {
    content: ''; position: absolute; right: 11px; top: 50%;
    transform: translateY(-50%); width: 0; height: 0;
    border-left: 4px solid transparent; border-right: 4px solid transparent;
    border-top: 4px solid var(--text-muted); pointer-events: none;
  }
  .ph-filter-search-wrap { position: relative; }
  .ph-filter-search-wrap svg {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%); pointer-events: none;
  }
  .ph-filter-input { padding-left: 34px; min-width: 200px; }
  .ph-filter-input::placeholder { color: var(--text-muted); }

  /* ─── Main Card ─── */
  .ph-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .ph-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px; border-bottom: 1px solid var(--border);
    background: var(--surface-2);
  }
  .ph-card-head-left { display: flex; align-items: center; gap: 10px; }
  .ph-card-icon {
    width: 32px; height: 32px; border-radius: 8px; background: #EEECEA;
    display: flex; align-items: center; justify-content: center;
  }
  .ph-card-title { font-size: 14px; font-weight: 700; letter-spacing: -.1px; margin: 0; }
  .ph-count-chip {
    background: #EEECEA; border: 1px solid var(--border);
    font-size: 12px; color: var(--text-secondary); font-weight: 600;
    padding: 3px 11px; border-radius: 99px; font-family: 'DM Mono', monospace;
  }

  /* ─── Table ─── */
  .ph-table { width: 100%; border-collapse: separate; border-spacing: 0; }
  .ph-table thead th {
    font-size: 11px; font-weight: 600; text-transform: uppercase;
    letter-spacing: .07em; color: var(--text-muted);
    padding: 11px 18px; border-bottom: 1px solid var(--border);
    white-space: nowrap; background: var(--surface);
  }
  .ph-table tbody .main-row { transition: background .12s; }
  .ph-table tbody .main-row:hover td { background: var(--surface-2); }
  .ph-table tbody td {
    padding: 13px 18px; font-size: 13.5px;
    border-bottom: 1px solid var(--border); vertical-align: middle;
  }
  .ph-table tbody .main-row:last-of-type td { border-bottom: none; }

  .td-no { font-family: 'DM Mono', monospace; font-size: 12px; color: var(--text-muted); width: 44px; }
  .td-ev-name { font-weight: 600; font-size: 13.5px; margin: 0 0 2px; }
  .td-ev-ref  { font-size: 11.5px; color: var(--text-muted); font-family: 'DM Mono', monospace; }
  .td-method {
    display: inline-block; padding: 3px 10px; border-radius: 6px;
    font-size: 11.5px; font-weight: 600;
    background: var(--blue-bg); color: var(--blue-text);
  }
  .td-amt { font-family: 'DM Mono', monospace; font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .td-date { font-family: 'DM Mono', monospace; font-size: 12px; color: var(--text-muted); line-height: 1.5; }
  .td-date-none { color: #D0CCC5; font-family: 'DM Mono', monospace; font-size: 13px; }

  /* Status Badges */
  .s-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11.5px; font-weight: 600; padding: 4px 11px;
    border-radius: 99px; white-space: nowrap;
  }
  .s-badge::before {
    content: ''; width: 5px; height: 5px;
    border-radius: 50%; flex-shrink: 0;
  }
  .s-paid     { background: var(--green-bg); color: var(--green-text); }
  .s-paid::before   { background: var(--green); }
  .s-pending  { background: var(--amber-bg); color: var(--amber-text); }
  .s-pending::before { background: var(--amber); animation: blink 1.6s ease infinite; }
  .s-failed   { background: var(--red-bg);   color: var(--red-text); }
  .s-failed::before { background: var(--red); }
  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.25} }

  /* Toggle Btn */
  .toggle-btn {
    width: 30px; height: 30px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 8px; border: 1px solid var(--border);
    background: var(--surface-2); cursor: pointer; color: var(--text-muted);
    transition: background .15s, border-color .15s;
  }
  .toggle-btn:hover { background: #EEECEA; border-color: rgba(0,0,0,.12); color: var(--text-primary); }
  .toggle-btn svg { transition: transform .22s; }
  .toggle-btn.open { background: var(--blue-bg); border-color: rgba(46,125,209,.3); color: var(--blue); }
  .toggle-btn.open svg { transform: rotate(180deg); }

  /* Detail Row */
  .detail-row td { padding: 0 !important; border-bottom: 1px solid var(--border) !important; }
  .detail-inner {
    display: grid; grid-template-columns: 1fr 1fr 1fr;
    background: var(--surface-2);
  }
  @media (max-width: 640px) { .detail-inner { grid-template-columns: 1fr; } }

  .detail-col { padding: 18px 20px; border-right: 1px solid var(--border); }
  .detail-col:last-child { border-right: none; }
  .detail-col-title {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--text-muted);
    margin-bottom: 14px; display: flex; align-items: center; gap: 7px;
  }
  .detail-col-title-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--text-muted); flex-shrink: 0;
  }
  .detail-field { margin-bottom: 10px; }
  .detail-field:last-child { margin-bottom: 0; }
  .detail-field-label { font-size: 11px; color: var(--text-muted); margin-bottom: 3px; }
  .detail-field-val { font-size: 13px; font-weight: 600; color: var(--text-primary); }
  .detail-field-code {
    font-family: 'DM Mono', monospace; font-size: 12px;
    color: var(--blue-text); background: var(--blue-bg);
    padding: 2px 8px; border-radius: 5px; display: inline-block;
  }

  /* Empty */
  .ph-empty { text-align: center; padding: 60px 24px; }
  .ph-empty-icon {
    width: 52px; height: 52px; background: #EEECEA; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
  }
  .ph-empty h3 { font-size: 16px; font-weight: 700; margin: 0 0 6px; letter-spacing: -.2px; }
  .ph-empty p  { font-size: 13px; color: var(--text-muted); margin: 0 0 18px; }
  .ph-empty-btn {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--text-primary); color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; padding: 9px 20px;
    border-radius: 99px; text-decoration: none; transition: opacity .15s;
  }
  .ph-empty-btn:hover { opacity: .82; color: #fff; text-decoration: none; }

  /* Pagination */
  .ph-pagination {
    padding: 16px 20px; border-top: 1px solid var(--border);
    display: flex; justify-content: flex-end;
  }
  .ph-pagination nav .flex { gap: 4px; }
  .ph-pagination nav span[aria-current="page"] > span,
  .ph-pagination nav a {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600;
    border-radius: 8px !important; border: 1px solid var(--border) !important;
    color: var(--text-secondary) !important; padding: 6px 12px !important;
    line-height: 1.4 !important; background: var(--surface) !important;
  }
  .ph-pagination nav span[aria-current="page"] > span {
    background: var(--text-primary) !important;
    color: #fff !important; border-color: var(--text-primary) !important;
  }
  .ph-pagination nav a:hover { background: #EEECEA !important; color: var(--text-primary) !important; }
</style>

<div class="ph-wrap">
  <div class="page-inner">

    {{-- Header --}}
    <div class="ph-header">
      <div>
        <h1>Riwayat Pembayaran</h1>
        <p>Semua transaksi dan status pembayaran Anda</p>
      </div>
      <a href="{{ route('user.dashboard') }}" class="ph-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Dashboard
      </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
      <div class="ph-alert success">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
        <button class="ph-alert-close" onclick="this.closest('.ph-alert').remove()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
    @endif

    {{-- Stats --}}
    <div class="ph-stats">
      <div class="ph-stat s-all">
        <div class="ph-stat-label">Total Pembayaran</div>
        <div class="ph-stat-val">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
      </div>
      <div class="ph-stat s-ok">
        <div class="ph-stat-label">Berhasil</div>
        <div class="ph-stat-val">Rp {{ number_format($successAmount, 0, ',', '.') }}</div>
      </div>
      <div class="ph-stat s-pend">
        <div class="ph-stat-label">Menunggu Verifikasi</div>
        <div class="ph-stat-val">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</div>
      </div>
      <div class="ph-stat s-fail">
        <div class="ph-stat-label">Gagal</div>
        <div class="ph-stat-val">Rp {{ number_format($failedAmount, 0, ',', '.') }}</div>
      </div>
    </div>

    {{-- Filter --}}
    <div class="ph-filter">
      <span class="ph-filter-label">Filter</span>
      <div class="ph-filter-select-wrap">
        <select class="ph-filter-select" id="filterStatus">
          <option value="">Semua Status</option>
          <option value="pending">Pending</option>
          <option value="success">Berhasil</option>
          <option value="failed">Gagal</option>
          <option value="cancelled">Dibatalkan</option>
        </select>
      </div>
      <div class="ph-filter-search-wrap">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#A8A49E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" class="ph-filter-input" placeholder="Cari event..." id="filterEvent">
      </div>
    </div>

    {{-- Table Card --}}
    <div class="ph-card">
      <div class="ph-card-head">
        <div class="ph-card-head-left">
          <div class="ph-card-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1A1917" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          </div>
          <p class="ph-card-title">Daftar Pembayaran</p>
        </div>
        <span class="ph-count-chip">{{ $payments->total() }} transaksi</span>
      </div>

      <div style="overflow-x:auto">
        <table class="ph-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Event</th>
              <th>Metode</th>
              <th>Jumlah</th>
              <th>Status</th>
              <th>Tanggal Bayar</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($payments as $payment)
              <tr class="main-row" data-payment="{{ $payment->id }}">
                <td class="td-no">{{ str_pad(($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                  <p class="td-ev-name">{{ Str::limit($payment->order->event->title ?? 'Event Tidak Ditemukan', 28) }}</p>
                  <span class="td-ev-ref">{{ $payment->order->payment_reference ?? 'Order #' . $payment->order->id }}</span>
                  @if($payment->order?->registration_code)
                    <br><span class="td-ev-ref">{{ $payment->order->registration_code }}</span>
                  @endif
                </td>
                <td>
                  <span class="td-method">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                </td>
                <td class="td-amt">Rp {{ number_format($payment->order->total_amount, 0, ',', '.') }}</td>
                <td>
                  @if($payment->order->status == 'pending')
                    <span class="s-badge s-pending">Pending</span>
                  @elseif($payment->order->status == 'paid')
                    <span class="s-badge s-paid">Paid</span>
                  @else
                    <span class="s-badge s-failed">Failed</span>
                  @endif
                </td>
                <td>
                  @if ($payment->paid_at)
                    <span class="td-date">{{ $payment->paid_at->format('d M Y') }}<br>{{ $payment->paid_at->format('H:i') }}</span>
                  @else
                    <span class="td-date-none">—</span>
                  @endif
                </td>
                <td>
                  <button class="toggle-btn toggleDetails" data-payment-id="{{ $payment->id }}" title="Lihat detail">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                  </button>
                </td>
              </tr>

              {{-- Detail Row --}}
              <tr class="detail-row detail-row-{{ $payment->id }} d-none">
                <td colspan="7">
                  <div class="detail-inner">
                    <div class="detail-col">
                      <div class="detail-col-title">
                        <span class="detail-col-title-dot"></span>
                        Informasi Registrasi
                      </div>
                      <div class="detail-field">
                        <div class="detail-field-label">Tanggal Registrasi</div>
                        <div class="detail-field-val">{{ $payment->order->created_at->format('d M Y, H:i') }}</div>
                      </div>
                      <div class="detail-field">
                        <div class="detail-field-label">Tipe Tiket</div>
                        @foreach ($payment->order->orderItems as $item)
                          <div class="detail-field-val">{{ $item->ticketType->name }} &times;{{ $item->quantity }}</div>
                        @endforeach
                      </div>
                    </div>
                    <div class="detail-col">
                      <div class="detail-col-title">
                        <span class="detail-col-title-dot"></span>
                        Informasi Pembayaran
                      </div>
                      <div class="detail-field">
                        <div class="detail-field-label">ID Transaksi</div>
                        <span class="detail-field-code">{{ $payment->transaction_id }}</span>
                      </div>
                      <div class="detail-field">
                        <div class="detail-field-label">Metode</div>
                        <div class="detail-field-val">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                      </div>
                    </div>
                    <div class="detail-col">
                      <div class="detail-col-title">
                        <span class="detail-col-title-dot"></span>
                        Detail Event
                      </div>
                      <div class="detail-field">
                        <div class="detail-field-label">Tanggal Event</div>
                        <div class="detail-field-val">{{ $payment->order->event->event_date->format('d M Y, H:i') }}</div>
                      </div>
                      <div class="detail-field">
                        <div class="detail-field-label">Lokasi</div>
                        <div class="detail-field-val">{{ Str::limit($payment->order->event->location, 30) }}</div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>

            @empty
              <tr>
                <td colspan="7">
                  <div class="ph-empty">
                    <div class="ph-empty-icon">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#A8A49E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <h3>Belum ada riwayat pembayaran</h3>
                    <p>Daftar ke event untuk memulai transaksi</p>
                    <a href="{{ route('user.events.index') }}" class="ph-empty-btn">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                      Cari Event
                    </a>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if ($payments->count() > 0)
        <div class="ph-pagination">
          {{ $payments->links() }}
        </div>
      @endif

    </div>

  </div>
</div>

@endsection

@section('ExtraJS')
<script>
  // Toggle detail row
  document.querySelectorAll('.toggleDetails').forEach(function(button) {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      var paymentId = this.getAttribute('data-payment-id');
      var detailRow = document.querySelector('.detail-row-' + paymentId);
      if (detailRow) {
        detailRow.classList.toggle('d-none');
        this.classList.toggle('open');
      }
    });
  });

  // Filter by status
  document.getElementById('filterStatus').addEventListener('change', function() {
    var status = this.value.toLowerCase();
    document.querySelectorAll('tbody .main-row').forEach(function(row) {
      var statusCell = row.querySelector('td:nth-child(5)');
      var payId = row.getAttribute('data-payment');
      var detailRow = document.querySelector('.detail-row-' + payId);
      var show = status === '' || statusCell.textContent.toLowerCase().includes(status);
      row.style.display = show ? 'table-row' : 'none';
      if (detailRow) detailRow.style.display = show ? '' : 'none';
    });
  });

  // Filter by event name
  document.getElementById('filterEvent').addEventListener('keyup', function() {
    var search = this.value.toLowerCase();
    document.querySelectorAll('tbody .main-row').forEach(function(row) {
      var eventCell = row.querySelector('td:nth-child(2)');
      var payId = row.getAttribute('data-payment');
      var detailRow = document.querySelector('.detail-row-' + payId);
      var show = eventCell.textContent.toLowerCase().includes(search);
      row.style.display = show ? 'table-row' : 'none';
      if (detailRow) detailRow.style.display = show ? '' : 'none';
    });
  });
</script>
@endsection