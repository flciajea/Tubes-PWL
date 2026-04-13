@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="page-inner">
            <!-- Breadcrumb -->
            <div class="page-header">
                <h4 class="page-title">Riwayat Pembayaran</h4>
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
                        <a href="#">Riwayat Pembayaran</a>
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
                    <!-- Filter Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm" id="filterStatus">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="success">Berhasil</option>
                                        <option value="failed">Gagal</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Event..."
                                        id="filterEvent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments Table -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Daftar Pembayaran</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Event</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            <td>
                                                {{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}
                                            </td>
                                            <td>
                                                {{-- Baris 80 ganti menjadi: --}}
                                                <strong>{{ Str::limit($payment->order->event->title ?? 'Event Tidak Ditemukan', 25) }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{-- Ambil kode dari order (sesuaikan kolomnya, misal: payment_reference atau id) --}}
                                                    {{ $payment->order->payment_reference ?? 'Order #' . $payment->order->id }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $payment->order?->registration_code ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>Rp.
                                                    {{ number_format($payment->order->total_amount, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                @if ($payment->payment_status === 'success')
                                                    <span class="badge bg-success">Berhasil</span>
                                                @elseif ($payment->payment_status === 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @else
                                                    <span class="badge bg-danger">Gagal</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($payment->paid_at)
                                                    {{ $payment->paid_at->format('d M Y H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Aksi
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @if ($payment->status === 'pending')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.payment.show', $payment->order->id) }}">
                                                                    <i class="fas fa-edit"></i> Lanjutkan Pembayaran
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if ($payment->status === 'success')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.payment.download-ticket', $payment->order->id) }}">
                                                                    <i class="fas fa-download"></i> Download Tiket
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.events.show', $payment->order->event->id) }}">
                                                                <i class="fas fa-eye"></i> Lihat Event
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item toggleDetails"
                                                                data-payment-id="{{ $payment->id }}">
                                                                <i class="fas fa-info-circle"></i> Detail
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Detail Row (Hidden by default) -->
                                        <tr class="detail-row-{{ $payment->id }} d-none">
                                            <td colspan="7">
                                                <div class="row p-3 bg-light">
                                                    <div class="col-md-4">
                                                        <h6>Informasi Registrasi</h6>
                                                        <p class="mb-1">
                                                            <small class="text-muted">Tanggal Registrasi:</small><br>
                                                            <strong>{{ $payment->order->created_at->format('d M Y H:i') }}</strong>
                                                        </p>
                                                        <p class="mb-0">
                                                            <small class="text-muted">Tiket Type:</small><br>
                                                            @foreach ($payment->order->orderItems as $item)
                                                                <strong>{{ $item->ticketType->name }}
                                                                    ({{ $item->quantity }}x)
                                                                </strong><br>
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6>Informasi Pembayaran</h6>
                                                        <p class="mb-1">
                                                            <small class="text-muted">ID Transaksi:</small><br>
                                                            <code>{{ $payment->transaction_id }}</code>
                                                        </p>
                                                        <p class="mb-0">
                                                            <small class="text-muted">Metode:</small><br>
                                                            <strong>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6>Detail Event</h6>
                                                        <p class="mb-1">
                                                            <small class="text-muted">Tanggal Event:</small><br>
                                                            <strong>{{ $payment->order->event->event_date->format('d M Y H:i') }}</strong>
                                                        </p>
                                                        <p class="mb-0">
                                                            <small class="text-muted">Lokasi:</small><br>
                                                            <strong>{{ Str::limit($payment->order->event->location, 30) }}</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <p class="text-muted mb-0">Belum ada riwayat pembayaran</p>
                                                <a href="{{ route('user.events.index') }}"
                                                    class="btn btn-sm btn-primary mt-2">
                                                    Cari Event
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($payments->count() > 0)
                            <div class="card-footer">
                                {{ $payments->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Payment Summary -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Total Pembayaran</h6>
                                    <h4 class="text-primary">
                                        Rp. {{ number_format($totalAmount, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Pembayaran Berhasil</h6>
                                    <h4 class="text-success">
                                        Rp. {{ number_format($successAmount, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Menunggu Verifikasi</h6>
                                    <h4 class="text-warning">
                                        Rp. {{ number_format($pendingAmount, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Pembayaran Gagal</h6>
                                    <h4 class="text-danger">
                                        Rp. {{ number_format($failedAmount, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ExtraJS')
    <script>
        // Toggle detail row
        document.querySelectorAll('.toggleDetails').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const paymentId = this.getAttribute('data-payment-id');
                const detailRow = document.querySelector(`.detail-row-${paymentId}`);
                if (detailRow) {
                    detailRow.classList.toggle('d-none');
                }
            });
        });

        // Filter by status
        document.getElementById('filterStatus').addEventListener('change', function() {
            const status = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr:not(.detail-row-*)');

            rows.forEach(row => {
                if (!row.classList.contains('detail-row-*')) {
                    const statusCell = row.querySelector('td:nth-child(5)');
                    if (status === '' || statusCell.textContent.toLowerCase().includes(status)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Filter by event name
        document.getElementById('filterEvent').addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                if (!row.classList.contains('detail-row-*')) {
                    const eventCell = row.querySelector('td:nth-child(2)');
                    if (eventCell.textContent.toLowerCase().includes(search)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection