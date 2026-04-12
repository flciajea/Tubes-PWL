@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <div class="page-header">
            <h4 class="page-title">Daftar Event</h4>
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
                    <a href="{{ route('user.events.index') }}">Event</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $event->title }}</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Daftar</a>
                </li>
            </ul>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Terjadi Kesalahan!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <!-- Form Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Formulir Pendaftaran Event</h5>
                    </div>
                    <div class="card-body">
                        <!-- Event Summary -->
                        <div class="alert alert-info">
                            <h6>{{ $event->title }}</h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar-alt"></i> 
                                {{ $event->event_date->format('d F Y, H:i') }} | 
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ $event->location }}
                            </p>
                        </div>

                        <!-- Registration Form -->
                        <form action="{{ route('user.events.store', $event->id) }}" method="POST">
                            @csrf

                            <!-- Ticket Type Selection -->
                            <div class="mb-4">
                                <label class="form-label" for="ticketType"><strong>Jenis Tiket *</strong></label>
                                <select class="form-select @error('ticket_type_id') is-invalid @enderror" 
                                        id="ticketType" 
                                        name="ticket_type_id" 
                                        required>
                                    <option value="">-- Pilih Jenis Tiket --</option>
                                    @foreach ($event->ticketTypes as $ticket)
                                        <option value="{{ $ticket->id }}"
                                                data-price="{{ $ticket->price }}"
                                                @if (old('ticket_type_id') == $ticket->id) selected @endif>
                                            {{ $ticket->name }} - Rp. {{ number_format($ticket->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ticket_type_id')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Quantity Selection -->
                            <div class="mb-4">
                                <label class="form-label" for="quantity"><strong>Jumlah Tiket *</strong></label>
                                <input type="number" 
                                       class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" 
                                       name="quantity" 
                                       min="1" 
                                       max="{{ $availableQuota }}"
                                       value="{{ old('quantity', 1) }}"
                                       required>
                                <small class="form-text text-muted">
                                    Maksimal: <strong>{{ $availableQuota }}</strong> tiket (Quota tersisa)
                                </small>
                                @error('quantity')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- User Info (Read Only) -->
                            <div class="mb-4">
                                <h6 class="mb-3">Data Pemesan</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Nama</strong></label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Email</strong></label>
                                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Nomor Telepon</strong></label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->phone }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        Saya menyetujui syarat dan ketentuan pendaftaran event ini
                                    </label>
                                </div>
                            </div>

                            <!-- Button Actions -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Lanjutkan ke Pembayaran
                                </button>
                                <a href="{{ route('user.events.show', $event->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="card-title">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Jenis Tiket:</span>
                                <span id="summaryTicket" class="fw-bold">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Harga Satuan:</span>
                                <span id="summaryPrice" class="fw-bold">Rp. 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Jumlah:</span>
                                <span id="summaryQty" class="fw-bold">0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fs-5"><strong>Total Harga:</strong></span>
                                <span id="summaryTotal" class="fs-5 fw-bold text-primary">Rp. 0</span>
                            </div>
                        </div>

                        <div class="alert alert-warning small mt-3">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Pembayaran harus diselesaikan dalam 1x24 jam setelah mendaftar.
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
    // Price mapping
    const priceMap = {
        @foreach ($event->ticketTypes as $ticket)
            '{{ $ticket->id }}': {{ $ticket->price }},
        @endforeach
    };

    document.getElementById('ticketType').addEventListener('change', updateSummary);
    document.getElementById('quantity').addEventListener('input', updateSummary);

    function updateSummary() {
        const ticketSelect = document.getElementById('ticketType');
        const quantityInput = document.getElementById('quantity');
        
        const selectedOption = ticketSelect.options[ticketSelect.selectedIndex];
        const ticketName = selectedOption.text.split(' - ')[0]; // Get name only
        const price = priceMap[ticketSelect.value] || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;

        document.getElementById('summaryTicket').textContent = ticketName || '-';
        document.getElementById('summaryPrice').textContent = 'Rp. ' + 
            new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('summaryQty').textContent = quantity;
        document.getElementById('summaryTotal').textContent = 'Rp. ' + 
            new Intl.NumberFormat('id-ID').format(total);
    }

    // Initial update
    updateSummary();
</script>
@endsection
