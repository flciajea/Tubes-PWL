@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <div class="page-header">
            <h4 class="page-title">Riwayat Event</h4>
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
                    <a href="#">Riwayat</a>
                </li>
            </ul>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Riwayat Pendaftaran Event</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Event</th>
                                    <th>Tiket</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal Event</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $reg)
                                    <tr>
                                        <td>{{ ($registrations->currentPage() - 1) * $registrations->perPage() + $loop->iteration }}</td>
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
                                        <td class="text-center">
                                            @foreach ($reg->orderItems as $item)
                                                {{ $item->quantity }}<br>
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
                                        <td>{{ $reg->event->event_date->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" 
                                                           href="{{ route('user.events.show', $reg->event->id) }}">
                                                            <i class="fas fa-eye"></i> Lihat Event
                                                        </a>
                                                    </li>
                                                    
                                                    @if ($reg->status === 'pending')
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item" 
                                                               href="{{ route('user.payment.show', $reg->id) }}">
                                                                <i class="fas fa-credit-card"></i> Lanjut Pembayaran
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('user.events.cancel', $reg->id) }}" 
                                                                  method="POST" 
                                                                  style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="dropdown-item text-danger" 
                                                                        onclick="return confirm('Batalkan order ini?')">
                                                                    <i class="fas fa-times"></i> Batalkan Order
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @elseif ($reg->status === 'paid')
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item" 
                                                               href="{{ route('user.payment.download-ticket', $reg->id) }}">
                                                                <i class="fas fa-download"></i> Unduh E-Ticket
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada riwayat pendaftaran event</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($registrations->count() > 0)
                        <div class="card-footer">
                            {{ $registrations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ExtraJS')
@endsection
