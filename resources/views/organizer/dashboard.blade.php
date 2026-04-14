@extends('layouts.master')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

  :root {
    --bg: #ffffff;
    --surface: #FFFFFF;
    --surface-2: #F9F8F5;
    --border: rgba(0,0,0,0.07);
    --border-strong: rgba(0,0,0,0.12);
    --text-primary: #1A1917;
    --text-secondary: #6B6860;
    --text-muted: #A8A49E;
    --green: #1D9E75;
    --green-bg: #E3F5EE;
    --green-text: #0A5E41;
    --blue: #2E7DD1;
    --blue-bg: #E4EFF9;
    --blue-text: #1145A0;
    --orange: #D95F35;
    --orange-bg: #FAEDE7;
    --orange-text: #8A3218;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.05);
  }

  .db-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 32px 48px;
    background: var(--bg);
    min-height: 100vh;
    color: var(--text-primary);
  }

  /* ─── Header ─── */
  .db-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 28px;
  }
  .db-header-left h1 {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -.4px;
    margin: 0 0 4px;
    color: var(--text-primary);
  }
  .db-header-left p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
    font-weight: 400;
  }
  .db-header-right {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .live-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--green-bg);
    color: var(--green-text);
    font-size: 12px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 99px;
    letter-spacing: .02em;
  }
  .live-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--green);
    animation: pulse 1.8s ease infinite;
  }
  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .5; transform: scale(.75); }
  }
  .export-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--text-primary);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 99px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity .15s, transform .15s;
    letter-spacing: .01em;
  }
  .export-btn:hover { opacity: .85; transform: translateY(-1px); color: #fff; text-decoration: none; }
  .export-btn svg { flex-shrink: 0; }

  /* ─── Stat Cards ─── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
  }
  @media (max-width: 768px) { .stats-grid { grid-template-columns: 1fr; } }

  .stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 22px 24px 20px;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
  }
  .stat-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
  }
  .stat-card::after {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: .06;
    transform: translate(20px, -20px);
  }
  .stat-card.green::after { background: var(--green); }
  .stat-card.blue::after { background: var(--blue); }
  .stat-card.orange::after { background: var(--orange); }

  .stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .stat-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .stat-chip {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 99px;
    letter-spacing: .04em;
    text-transform: uppercase;
  }
  .stat-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    letter-spacing: .03em;
    text-transform: uppercase;
    margin-bottom: 6px;
  }
  .stat-value {
    font-size: 26px;
    font-weight: 700;
    letter-spacing: -.6px;
    margin: 0 0 16px;
    line-height: 1;
    font-family: 'DM Mono', monospace;
  }
  .stat-footer {
    display: flex;
    align-items: center;
    gap: 6px;
    padding-top: 14px;
    border-top: 1px solid var(--border);
    font-size: 12px;
    color: var(--text-muted);
  }

  /* ─── Chart Card ─── */
  .chart-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 28px;
    box-shadow: var(--shadow);
    margin-bottom: 20px;
  }
  .chart-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
  }
  .chart-title {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -.3px;
    margin: 0 0 4px;
  }
  .chart-sub {
    font-size: 12.5px;
    color: var(--text-muted);
    margin: 0;
  }
  .chart-legend {
    display: flex;
    align-items: center;
    gap: 7px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    padding: 5px 12px;
    border-radius: 99px;
  }
  .legend-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--blue);
  }
  .legend-label {
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 500;
  }

  /* ─── Table Card ─── */
  .table-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 28px;
    box-shadow: var(--shadow);
    margin-bottom: 20px;
  }
  .table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .section-title {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -.3px;
    margin: 0;
  }
  .count-chip {
    background: var(--surface-2);
    border: 1px solid var(--border);
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 600;
    padding: 3px 11px;
    border-radius: 99px;
    font-family: 'DM Mono', monospace;
  }

  .db-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }
  .db-table thead th {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-muted);
    padding: 0 12px 12px;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
  }
  .db-table thead th:first-child { padding-left: 0; }
  .db-table tbody tr { transition: background .12s; }
  .db-table tbody tr:hover td { background: var(--surface-2); }
  .db-table tbody td {
    font-size: 13.5px;
    padding: 13px 12px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    color: var(--text-primary);
  }
  .db-table tbody td:first-child { padding-left: 0; }
  .db-table tbody tr:last-child td { border-bottom: none; }

  .td-event { font-weight: 600; font-size: 13px; }
  .td-revenue {
    font-family: 'DM Mono', monospace;
    font-size: 13px;
    font-weight: 500;
    color: var(--green-text);
  }
  .td-num {
    font-family: 'DM Mono', monospace;
    font-size: 13px;
    color: var(--text-secondary);
  }
  .td-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--orange-bg);
    color: var(--orange-text);
    font-size: 12px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 99px;
    font-family: 'DM Mono', monospace;
  }
</style>

<div class="db-wrap">

  {{-- Header --}}
  <div class="db-header">
    <div class="db-header-left">
      <h1>Dashboard Penjualan</h1>
      <p>Ringkasan performa event & pendapatan secara real-time</p>
    </div>
    <div class="db-header-right">
      <span class="live-badge">Live</span>
      <a href="/organizer/export-excel" class="export-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export Excel
      </a>
    </div>
  </div>

  {{-- Stat Cards --}}
  <div class="stats-grid">

    {{-- Revenue --}}
    <div class="stat-card green">
      <div class="stat-top">
        <div class="stat-icon" style="background:var(--green-bg)">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#0A5E41" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
          </svg>
        </div>
        <span class="stat-chip" style="background:var(--green-bg);color:var(--green-text)">Revenue</span>
      </div>
      <div class="stat-label">Total Revenue</div>
      <p class="stat-value" style="color:var(--green-text)">Rp {{ number_format($totalRevenue,0,',','.') }}</p>
      <div class="stat-footer">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Akumulasi seluruh transaksi
      </div>
    </div>

    {{-- Transaksi --}}
    <div class="stat-card blue">
      <div class="stat-top">
        <div class="stat-icon" style="background:var(--blue-bg)">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#1145A0" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
          </svg>
        </div>
        <span class="stat-chip" style="background:var(--blue-bg);color:var(--blue-text)">Transaksi</span>
      </div>
      <div class="stat-label">Total Transaksi</div>
      <p class="stat-value" style="color:var(--blue-text)">{{ $totalTransactions }}</p>
      <div class="stat-footer">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Jumlah order masuk
      </div>
    </div>

    {{-- Tiket --}}
    <div class="stat-card orange">
      <div class="stat-top">
        <div class="stat-icon" style="background:var(--orange-bg)">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#8A3218" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
          </svg>
        </div>
        <span class="stat-chip" style="background:var(--orange-bg);color:var(--orange-text)">Tiket</span>
      </div>
      <div class="stat-label">Total Tiket Terjual</div>
      <p class="stat-value" style="color:var(--orange-text)">{{ $totalTickets }}</p>
      <div class="stat-footer">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Tiket berhasil diterbitkan
      </div>
    </div>

  </div>

  {{-- Chart --}}
  <div class="chart-card">
    <div class="chart-header">
      <div>
        <p class="chart-title">Grafik Revenue</p>
        <p class="chart-sub">Tren pendapatan dari waktu ke waktu</p>
      </div>
      <div class="chart-legend">
        <span class="legend-dot"></span>
        <span class="legend-label">Revenue</span>
      </div>
    </div>
    <div style="position: relative; height: 260px;">
      <canvas id="chart"></canvas>
    </div>
  </div>

  {{-- Table --}}
  <div class="table-card">
    <div class="table-card-header">
      <p class="section-title">Event Performance</p>
      <span class="count-chip">{{ count($eventAnalytics) }} event</span>
    </div>
    <div class="table-responsive">
      <table class="db-table">
        <thead>
          <tr>
            <th>Nama Event</th>
            <th>Revenue</th>
            <th>Transaksi</th>
            <th>Tiket Terjual</th>
          </tr>
        </thead>
        <tbody>
          @foreach($eventAnalytics as $event)
          <tr>
            <td class="td-event">{{ $event['event_name'] }}</td>
            <td class="td-revenue">Rp {{ number_format($event['revenue'],0,',','.') }}</td>
            <td class="td-num">{{ $event['transactions'] }}</td>
            <td>
              <span class="td-badge">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $event['tickets'] }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($chartData->pluck('tanggal'));
const data = @json($chartData->pluck('total'));

new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Revenue',
            data: data,
            borderColor: '#2E7DD1',
            backgroundColor: (ctx) => {
                const canvas = ctx.chart.ctx;
                const gradient = canvas.createLinearGradient(0, 0, 0, 220);
                gradient.addColorStop(0, 'rgba(46,125,209,0.14)');
                gradient.addColorStop(1, 'rgba(46,125,209,0.0)');
                return gradient;
            },
            borderWidth: 2,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#2E7DD1',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 7,
            pointHoverBackgroundColor: '#2E7DD1',
            pointHoverBorderColor: '#fff',
            pointHoverBorderWidth: 2,
            tension: 0.42,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1A1917',
                titleColor: 'rgba(255,255,255,0.55)',
                bodyColor: '#fff',
                borderColor: 'rgba(255,255,255,0.08)',
                borderWidth: 1,
                padding: 14,
                cornerRadius: 10,
                titleFont: { family: 'Plus Jakarta Sans', size: 11, weight: '500' },
                bodyFont: { family: 'DM Mono', size: 13, weight: '500' },
                callbacks: {
                    label: ctx => '  Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: {
                grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                border: { display: false },
                ticks: { color: '#A8A49E', font: { family: 'Plus Jakarta Sans', size: 11 }, autoSkip: false, maxRotation: 0 }
            },
            y: {
                grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                border: { display: false },
                ticks: {
                    color: '#A8A49E',
                    font: { family: 'DM Mono', size: 11 },
                    callback: v => 'Rp ' + (v/1000000).toFixed(1) + ' jt'
                }
            }
        }
    }
});
</script>

@endsection