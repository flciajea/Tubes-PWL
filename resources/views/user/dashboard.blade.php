@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Header Section -->
        <div class="page-header">
            <h4 class="page-title">Dashboard User</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('user.dashboard') }}">
                        <span class="icon-heart"></span>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Dashboard</a>
                </li>
            </ul>
        </div>

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}! 👋</h5>
                        <p class="card-text mb-0">
                            Kelola event, lihat registrasi, dan cek status pembayaran Anda di sini.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Total Events</h6>
                        <h3 class="text-primary">{{ $registrations->count() }}</h3>
                        <small class="text-muted">Event yang terdaftar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Upcoming Events</h6>
                        <h3 class="text-success">{{ $upcomingEvents->count() }}</h3>
                        <small class="text-muted">Event yang akan datang</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Pending Payments</h6>
                        <h3 class="text-warning">
                            {{ $registrations->filter(fn($r) => $r->status === 'pending')->count() }}
                        </h3>
                        <small class="text-muted">Menunggu pembayaran</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Confirmed</h6>
                        <h3 class="text-info">
                            {{ $registrations->filter(fn($r) => $r->status === 'paid')->count() }}
                        </h3>
                        <small class="text-muted">Event terkonfirmasi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="btn-group" role="group">
                    <a href="{{ route('user.events.index') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari Event
                    </a>
                    <a href="{{ route('user.events.history') }}" class="btn btn-info">
                        <i class="fas fa-history"></i> Riwayat
                    </a>
                    <a href="{{ route('user.payment.history') }}" class="btn btn-secondary">
                        <i class="fas fa-receipt"></i> Riwayat Pembayaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        @if ($upcomingEvents->count() > 0)
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-calendar-check"></i> Event Mendatang
                            </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Tiket</th>
                                        <th>Qty</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($upcomingEvents->take(5) as $reg)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($reg->event->title, 25) }}</strong>
                                            </td>
                                            <td>{{ $reg->event->event_date->format('d M Y') }}</td>
                                            <td>{{ Str::limit($reg->event->location, 20) }}</td>
                                            <td>
                                                @foreach ($reg->orderItems as $item)
                                                    {{ $item->ticketType->name }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($reg->orderItems as $item)
                                                    {{ $item->quantity }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Terkonfirmasi</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.events.show', $reg->event->id) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Registrations -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-list"></i> Registrasi Terbaru
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Tiket</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations->take(10) as $reg)
                                    <tr>
                                        <td>
                                            <strong>{{ Str::limit($reg->event->title, 30) }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $reg->payment_reference }}</small>
                                        </td>
                                        <td>
                                            @foreach ($reg->orderItems as $item)
                                                {{ $item->ticketType->name }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <strong>Rp. {{ number_format($reg->total_amount, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            @if ($reg->status === 'paid')
                                                <span class="badge bg-success">Terkonfirmasi</span>
                                            @elseif ($reg->status === 'pending')
                                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>{{ $reg->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($reg->status === 'pending')
                                                <a href="{{ route('user.payment.show', $reg->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Lanjut Pembayaran">
                                                    <i class="fas fa-credit-card"></i>
                                                </a>
                                            @elseif ($reg->status === 'paid')
                                                <a href="{{ route('user.payment.download-ticket', $reg->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Unduh Tiket">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('user.events.show', $reg->event->id) }}" 
                                               class="btn btn-sm btn-secondary" 
                                               title="Lihat Event">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada registrasi event</p>
                                            <a href="{{ route('user.events.index') }}" class="btn btn-sm btn-primary mt-2">
                                                Jelajahi Event
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("ExtraCSS")
@endsection

@section("ExtraJS")
@endsection



