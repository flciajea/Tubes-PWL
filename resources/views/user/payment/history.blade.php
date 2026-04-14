@extends('layouts.master')

@section('content')
    <style>
        .hist-wrap {
            padding: 1.5rem 0 3rem;
        }

        /* Breadcrumb */
        .hist-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #888;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .hist-breadcrumb a {
            color: #888;
            text-decoration: none;
            transition: color .15s;
        }

        .hist-breadcrumb a:hover {
            color: #111;
        }

        .hist-breadcrumb .sep {
            font-size: 10px;
            opacity: .5;
        }

        /* Page title */
        .hist-title {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            margin-bottom: 1.5rem;
        }

        /* Alerts */
        .hist-alert-success {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: .875rem 1rem;
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 10px;
            margin-bottom: 1.25rem;
        }

        .hist-alert-success i {
            color: #16a34a;
            font-size: 14px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .hist-alert-success p {
            font-size: 13px;
            color: #15803d;
            margin: 0;
            line-height: 1.5;
        }

        /* Stat cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 800px) {
            .stat-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #aaa;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-label i {
            font-size: 11px;
        }

        .stat-val {
            font-size: 20px;
            font-weight: 700;
            color: #111;
            line-height: 1;
        }

        .stat-card.s-all .stat-label i {
            color: #3b82f6;
        }

        .stat-card.s-all .stat-val {
            color: #3b82f6;
        }

        .stat-card.s-ok .stat-label i {
            color: #16a34a;
        }

        .stat-card.s-ok .stat-val {
            color: #16a34a;
        }

        .stat-card.s-pend .stat-label i {
            color: #d97706;
        }

        .stat-card.s-pend .stat-val {
            color: #d97706;
        }

        .stat-card.s-fail .stat-label i {
            color: #dc2626;
        }

        .stat-card.s-fail .stat-val {
            color: #dc2626;
        }

        /* Filter bar */
        .filter-bar {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 12px;
            padding: .875rem 1.25rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .filter-bar-label {
            font-size: 12px;
            font-weight: 600;
            color: #aaa;
            white-space: nowrap;
        }

        .filter-select {
            height: 34px;
            padding: 0 .75rem;
            font-size: 13px;
            border: 1px solid #e0e0e0;
            border-radius: 7px;
            background: #fafafa;
            color: #111;
            outline: none;
            font-family: inherit;
        }

        .filter-select:focus {
            border-color: #93c5fd;
            background: #fff;
        }

        .filter-input {
            height: 34px;
            padding: 0 .75rem 0 2rem;
            font-size: 13px;
            border: 1px solid #e0e0e0;
            border-radius: 7px;
            background: #fafafa;
            color: #111;
            outline: none;
            font-family: inherit;
            min-width: 180px;
        }

        .filter-input:focus {
            border-color: #93c5fd;
            background: #fff;
        }

        .filter-search-wrap {
            position: relative;
        }

        .filter-search-wrap i {
            position: absolute;
            left: .625rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: #bbb;
            pointer-events: none;
        }

        /* Main card */
        .hist-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 14px;
            overflow: hidden;
        }

        .hist-card-header {
            padding: .875rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hist-card-header h5 {
            font-size: 14px;
            font-weight: 600;
            color: #111;
            margin: 0;
        }

        .hist-card-header span {
            font-size: 12px;
            color: #aaa;
        }

        /* Table */
        .hist-table-wrap {
            overflow-x: auto;
        }

        .hist-table {
            width: 100%;
            border-collapse: collapse;
        }

        .hist-table thead tr {
            background: #fafafa;
        }

        .hist-table th {
            padding: .625rem 1rem;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #aaa;
            white-space: nowrap;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
        }

        .hist-table td {
            padding: .875rem 1rem;
            font-size: 13px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
        }

        .hist-table tbody tr:hover>td {
            background: #fafafa;
        }

        .hist-table tbody tr:last-child>td {
            border-bottom: none;
        }

        /* Event cell */
        .ev-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
            margin-bottom: 2px;
        }

        .ev-ref {
            font-size: 11px;
            font-family: monospace;
            color: #888;
            letter-spacing: .3px;
        }

        /* Method badge */
        .method-badge {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background: #eff6ff;
            color: #2563eb;
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .sb-success {
            background: #f0fdf4;
            color: #15803d;
        }

        .sb-success::before {
            background: #22c55e;
        }

        .sb-pending {
            background: #fffbeb;
            color: #b45309;
        }

        .sb-pending::before {
            background: #f59e0b;
        }

        .sb-failed {
            background: #fff5f5;
            color: #b91c1c;
        }

        .sb-failed::before {
            background: #ef4444;
        }

        /* Amount */
        .amt {
            font-size: 13px;
            font-weight: 700;
            color: #111;
        }

        /* Date */
        .dt {
            font-size: 12px;
            color: #555;
        }

        .dt-none {
            color: #ccc;
        }

        /* Toggle btn */
        .toggle-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid #e0e0e0;
            background: #fafafa;
            cursor: pointer;
            color: #888;
            font-size: 12px;
            transition: background .15s, border-color .15s, transform .2s;
        }

        .toggle-btn:hover {
            background: #f0f0f0;
            border-color: #ccc;
        }

        .toggle-btn.open {
            background: #f0f7ff;
            border-color: #93c5fd;
            color: #3b82f6;
            transform: rotate(180deg);
        }

        /* Detail row */
        .detail-row {
            background: #fafafa;
        }

        .detail-row td {
            padding: 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-inner {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0;
        }

        @media (max-width: 600px) {
            .detail-inner {
                grid-template-columns: 1fr;
            }
        }

        .detail-col {
            padding: 1rem 1.25rem;
            border-right: 1px solid #f0f0f0;
        }

        .detail-col:last-child {
            border-right: none;
        }

        .detail-col-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #aaa;
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .detail-col-title i {
            font-size: 11px;
        }

        .detail-field {
            margin-bottom: .625rem;
        }

        .detail-field:last-child {
            margin-bottom: 0;
        }

        .detail-field-label {
            font-size: 11px;
            color: #bbb;
            margin-bottom: 2px;
        }

        .detail-field-val {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .detail-field-code {
            font-size: 12px;
            font-family: monospace;
            color: #3b82f6;
            background: #eff6ff;
            padding: 2px 7px;
            border-radius: 5px;
            display: inline-block;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .empty-state-icon i {
            font-size: 22px;
            color: #ccc;
        }

        .empty-state p {
            font-size: 14px;
            color: #888;
            margin-bottom: 1rem;
        }

        .btn-find {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: .5rem 1.125rem;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-find:hover {
            opacity: .85;
            color: #fff;
            text-decoration: none;
        }

        /* Pagination */
        .hist-footer {
            padding: .875rem 1.25rem;
            border-top: 1px solid #f0f0f0;
        }
    </style>

    <div class="hist-wrap">
        <div class="page-inner">

            <!-- Breadcrumb -->
            <div class="hist-breadcrumb">
                <a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a>
                <span class="sep">›</span>
                <span>Riwayat Pembayaran</span>
            </div>

            <div class="hist-title">Riwayat Pembayaran</div>

            <!-- Success alert -->
            @if (session('success'))
                <div class="hist-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Stat cards -->
            <div class="stat-grid">
                <div class="stat-card s-all">
                    <div class="stat-label"><i class="fas fa-layer-group"></i> Total Pembayaran</div>
                    <div class="stat-val">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                </div>
                <div class="stat-card s-ok">
                    <div class="stat-label"><i class="fas fa-check-circle"></i> Berhasil</div>
                    <div class="stat-val">Rp {{ number_format($successAmount, 0, ',', '.') }}</div>
                </div>
                <div class="stat-card s-pend">
                    <div class="stat-label"><i class="fas fa-clock"></i> Menunggu Verifikasi</div>
                    <div class="stat-val">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</div>
                </div>
                <div class="stat-card s-fail">
                    <div class="stat-label"><i class="fas fa-times-circle"></i> Gagal</div>
                    <div class="stat-val">Rp {{ number_format($failedAmount, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Filter bar -->
            <div class="filter-bar">
                <span class="filter-bar-label">Filter:</span>
                <select class="filter-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="success">Berhasil</option>
                    <option value="failed">Gagal</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                <div class="filter-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" class="filter-input" placeholder="Cari Event..." id="filterEvent">
                </div>
            </div>

            <!-- Table card -->
            <div class="hist-card">
                <div class="hist-card-header">
                    <h5><i class="fas fa-receipt" style="margin-right:6px;color:#aaa"></i>Daftar Pembayaran</h5>
                    <span>{{ $payments->total() }} transaksi</span>
                </div>

                <div class="hist-table-wrap">
                    <table class="hist-table">
                        <thead>
                            <tr>
                                <th style="width:44px">No</th>
                                <th>Event</th>
                                <th>Metode</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th style="width:48px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr class="main-row" data-payment="{{ $payment->id }}">
                                    <td style="color:#bbb;font-size:12px">
                                        {{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="ev-name">
                                            {{ Str::limit($payment->order->event->title ?? 'Event Tidak Ditemukan', 25) }}</div>
                                        <div class="ev-ref">
                                            {{ $payment->order->payment_reference ?? 'Order #' . $payment->order->id }}</div>
                                        @if($payment->order?->registration_code)
                                            <div class="ev-ref">{{ $payment->order->registration_code }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="method-badge">
                                            {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amt">Rp
                                            {{ number_format($payment->order->total_amount, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @if($payment->order->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($payment->order->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment->paid_at)
                                            <span
                                                class="dt">{{ $payment->paid_at->format('d M Y') }}<br>{{ $payment->paid_at->format('H:i') }}</span>
                                        @else
                                            <span class="dt-none">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="toggle-btn toggleDetails" data-payment-id="{{ $payment->id }}"
                                            title="Lihat detail">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Detail row -->
                                <tr class="detail-row detail-row-{{ $payment->id }} d-none">
                                    <td colspan="7">
                                        <div class="detail-inner">
                                            <div class="detail-col">
                                                <div class="detail-col-title"><i class="fas fa-clipboard-list"></i> Informasi
                                                    Registrasi</div>
                                                <div class="detail-field">
                                                    <div class="detail-field-label">Tanggal Registrasi</div>
                                                    <div class="detail-field-val">
                                                        {{ $payment->order->created_at->format('d M Y, H:i') }}</div>
                                                </div>
                                                <div class="detail-field">
                                                    <div class="detail-field-label">Tipe Tiket</div>
                                                    @foreach ($payment->order->orderItems as $item)
                                                        <div class="detail-field-val">{{ $item->ticketType->name }}
                                                            &times;{{ $item->quantity }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="detail-col">
                                                <div class="detail-col-title"><i class="fas fa-credit-card"></i> Informasi
                                                    Pembayaran</div>
                                                <div class="detail-field">
                                                    <div class="detail-field-label">ID Transaksi</div>
                                                    <span class="detail-field-code">{{ $payment->transaction_id }}</span>
                                                </div>
                                                <div class="detail-field">
                                                    <div class="detail-field-label">Metode</div>
                                                    <div class="detail-field-val">
                                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                                </div>
                                            </div>
                                            <div class="detail-col">
                                                <div class="detail-col-title"><i class="fas fa-calendar-alt"></i> Detail Event
                                                </div>
                                                <div class="detail-field">
                                                    <div class="detail-field-label">Tanggal Event</div>
                                                    <div class="detail-field-val">
                                                        {{ $payment->order->event->event_date->format('d M Y, H:i') }}</div>
                                                </div>
                                                <div class="detail-field">
                                                    <div class="detail-field-label">Lokasi</div>
                                                    <div class="detail-field-val">
                                                        {{ Str::limit($payment->order->event->location, 30) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-state-icon"><i class="fas fa-receipt"></i></div>
                                            <p>Belum ada riwayat pembayaran</p>
                                            <a href="{{ route('user.events.index') }}" class="btn-find">
                                                <i class="fas fa-search"></i> Cari Event
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($payments->count() > 0)
                    <div class="hist-footer">
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
        document.querySelectorAll('.toggleDetails').forEach(function (button) {
            button.addEventListener('click', function (e) {
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
        document.getElementById('filterStatus').addEventListener('change', function () {
            var status = this.value.toLowerCase();
            document.querySelectorAll('tbody .main-row').forEach(function (row) {
                var statusCell = row.querySelector('td:nth-child(5)');
                var payId = row.getAttribute('data-payment');
                var detailRow = document.querySelector('.detail-row-' + payId);
                var show = status === '' || statusCell.textContent.toLowerCase().includes(status);
                row.style.display = show ? 'table-row' : 'none';
                if (detailRow) detailRow.style.display = show ? '' : 'none';
            });
        });

        // Filter by event name
        document.getElementById('filterEvent').addEventListener('keyup', function () {
            var search = this.value.toLowerCase();
            document.querySelectorAll('tbody .main-row').forEach(function (row) {
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