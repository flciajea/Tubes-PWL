@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold text-dark">Riwayat Pesanan</h1>
            <p class="text-muted">Pantau status transaksi dan riwayat pembelian tiket Anda di sini.</p>
        </div>
        <div class="col-md-4 text-md-end align-self-center">
            <span class="badge bg-light text-dark border p-2">Total: {{ $orders->count() }} Pesanan</span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-xs fw-bold text-muted">#</th>
                            <th class="py-3 text-uppercase fs-xs fw-bold text-muted">User</th>
                            <th class="py-3 text-uppercase fs-xs fw-bold text-muted">Event / Tiket</th>
                            <th class="py-3 text-uppercase fs-xs fw-bold text-muted text-center">Status</th>
                            <th class="py-3 text-uppercase fs-xs fw-bold text-muted">Waktu Selesai</th>
                            <th class="pe-4 py-3 text-uppercase fs-xs fw-bold text-muted text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->orderItems->first()->ticketType->event->title ?? 'N/A' }}</div>
                                <div class="text-muted small"><i class="bi bi-tag-fill me-1"></i>{{ $order->orderItems->first()->ticketType->name ?? '-' }}</div>
                            </td>
                            <td class="text-center">
                                @if($order->status == 'paid')
                                    <span class="badge rounded-pill bg-success-soft text-success border border-success px-3">
                                        <i class="bi bi-check-circle-fill me-1"></i> Approved
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3">
                                        <i class="bi bi-x-circle-fill me-1"></i> {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark small fw-medium">{{ $order->updated_at->format('d M Y') }}</div>
                                <div class="text-muted smaller">{{ $order->updated_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="pe-4 text-end">
                                @if($order->payment?->payment_proof)
                                    <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-eye-fill me-1"></i> Bukti
                                    </a>
                                @else
                                    <span class="text-muted small italic">Tidak ada bukti</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="Empty" style="width: 80px;" class="mb-3 opacity-50">
                                <p class="text-muted fw-medium">Belum ada riwayat pesanan ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection