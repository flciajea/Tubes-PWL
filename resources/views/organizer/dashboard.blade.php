@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Revenue</h5>
            <h3>Rp {{ number_format($totalRevenue,0,',','.') }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Transaksi</h5>
            <h3>{{ $totalTransactions }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Tiket Terjual</h5>
            <h3>{{ $totalTickets }}</h3>
        </div>
    </div>
</div>

<div class="card mt-4 p-3">
    <h5>Grafik Revenue</h5>
    <canvas id="chart"></canvas>
</div>

<form method="POST" action="/logout">
@csrf
<button type="submit">Logout</button>
</form>

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
            data: data
        }]
    }
});
</script>

@endsection