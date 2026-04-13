@extends('layouts.master')

@section('content')

<style>
  .dash-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
  .dash-title { font-size: 18px; font-weight: 500; margin: 0; }
  .dash-sub { font-size: 13px; color: #6c757d; margin: 2px 0 0; }
  .live-pill { font-size: 11px; padding: 4px 12px; border-radius: 99px; background: #EAF3DE; color: #27500A; font-weight: 500; }

  .stat-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.09); border-radius: 12px; padding: 1.1rem 1.25rem; position: relative; overflow: hidden; }
  .stat-card .accent { position: absolute; top: 0; left: 0; width: 3px; height: 100%; border-radius: 3px 0 0 3px; }
  .stat-card .icon-wrap { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
  .stat-card .top-row { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
  .stat-card .badge { font-size: 10px; padding: 2px 8px; border-radius: 99px; font-weight: 500; }
  .stat-card .stat-label { font-size: 12px; color: #6c757d; margin-bottom: 5px; letter-spacing: .01em; }
  .stat-card .stat-value { font-size: 21px; font-weight: 500; margin: 0; line-height: 1.1; }
  .stat-card .divider { height: 0.5px; background: rgba(0,0,0,0.07); margin: 10px 0; }
  .stat-card .foot { font-size: 11px; color: #aaa; }

  .chart-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.09); border-radius: 12px; padding: 1.25rem 1.5rem; margin-top: 14px; }
  .chart-card .chart-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
  .chart-card .chart-title { font-size: 15px; font-weight: 500; margin: 0; }
  .chart-card .chart-sub { font-size: 12px; color: #6c757d; margin: 2px 0 0; }
  .chart-card .legend-row { display: flex; align-items: center; gap: 6px; }
  .chart-card .legend-dot { width: 8px; height: 8px; border-radius: 50%; background: #378ADD; }
  .chart-card .legend-label { font-size: 12px; color: #6c757d; }
</style>

<div class="dash-header">
  <div>
    <h5 class="dash-title">Dashboard Penjualan</h5>
  </div>
  <span class="live-pill">Live</span>
</div>

<div class="row g-3">

  <div class="col-md-4">
    <div class="stat-card">
      <div class="accent" style="background:#1D9E75"></div>
      <div class="top-row">
        <div class="icon-wrap" style="background:#E1F5EE">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0F6E56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
          </svg>
        </div>
        <span class="badge" style="background:#E1F5EE;color:#085041">Revenue</span>
      </div>
      <div class="stat-label">Total Revenue</div>
      <p class="stat-value">Rp {{ number_format($totalRevenue,0,',','.') }}</p>
      <div class="divider"></div>
      <div class="foot">Akumulasi seluruh transaksi</div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="stat-card">
      <div class="accent" style="background:#378ADD"></div>
      <div class="top-row">
        <div class="icon-wrap" style="background:#E6F1FB">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#185FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
          </svg>
        </div>
        <span class="badge" style="background:#E6F1FB;color:#0C447C">Transaksi</span>
      </div>
      <div class="stat-label">Total Transaksi</div>
      <p class="stat-value">{{ $totalTransactions }}</p>
      <div class="divider"></div>
      <div class="foot">Jumlah order masuk</div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="stat-card">
      <div class="accent" style="background:#D85A30"></div>
      <div class="top-row">
        <div class="icon-wrap" style="background:#FAECE7">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#993C1D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
            <line x1="9" y1="9" x2="9" y2="15" stroke-dasharray="2 2"/>
            <line x1="15" y1="9" x2="15" y2="15" stroke-dasharray="2 2"/>
          </svg>
        </div>
        <span class="badge" style="background:#FAECE7;color:#712B13">Tiket</span>
      </div>
      <div class="stat-label">Total Tiket Terjual</div>
      <p class="stat-value">{{ $totalTickets }}</p>
      <div class="divider"></div>
      <div class="foot">Tiket berhasil diterbitkan</div>
    </div>
  </div>

</div>

<div class="chart-card">
  <div class="chart-header">
    <div>
      <p class="chart-title">Grafik Revenue</p>
      <p class="chart-sub">Tren pendapatan dari waktu ke waktu</p>
    </div>
    <div class="legend-row">
      <span class="legend-dot"></span>
      <span class="legend-label">Revenue</span>
    </div>
  </div>
  <div style="position: relative; height: 280px;">
    <canvas id="chart"></canvas>
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
            borderColor: '#378ADD',
            backgroundColor: 'rgba(55,138,221,0.07)',
            borderWidth: 2,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#378ADD',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointHoverBackgroundColor: '#378ADD',
            tension: 0.45,
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
                backgroundColor: '#fff',
                titleColor: '#2C2C2A',
                bodyColor: '#5F5E5A',
                borderColor: '#D3D1C7',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => '  Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: {
                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                border: { display: false },
                ticks: { color: '#888', font: { size: 12 }, autoSkip: false, maxRotation: 0 }
            },
            y: {
                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                border: { display: false, dash: [4,4] },
                ticks: {
                    color: '#888',
                    font: { size: 12 },
                    callback: v => 'Rp ' + (v/1000000).toFixed(1) + ' jt'
                }
            }
        }
    }
});
</script>

@endsection