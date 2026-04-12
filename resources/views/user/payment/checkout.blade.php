@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <div class="page-header">
            <h4 class="page-title">Pembayaran</h4>
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
                    <a href="#">Pembayaran</a>
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
            <!-- Payment Form Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Detail Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <!-- Event Information -->
                        <div class="alert alert-info">
                            <h6>{{ $order->event->title }}</h6>
                            <p class="mb-1">
                                <i class="fas fa-ticket-alt"></i> 
                                @foreach ($order->orderItems as $item)
                                    Tiket: {{ $item->ticketType->name }} (Qty: {{ $item->quantity }})<br>
                                @endforeach
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-code"></i> 
                                <strong>{{ $order->payment_reference }}</strong>
                            </p>
                        </div>

                        <!-- Payment Form -->
                        <form action="{{ route('user.payment.process', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Payment Method Selection -->
                            <div class="mb-4">
                                <h6 class="mb-3"><strong>Pilih Metode Pembayaran</strong></h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" id="bankTransfer" name="payment_channel" value="Bank Transfer" required>
                                            <label class="form-check-label d-block" for="bankTransfer" style="cursor: pointer;">
                                                <div class="card mb-0">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-university fa-2x mb-2" style="color: #007bff;"></i>
                                                        <h6 class="mb-0">Transfer Bank</h6>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" id="creditCard" name="payment_channel" value="Credit Card" required>
                                            <label class="form-check-label d-block" for="creditCard" style="cursor: pointer;">
                                                <div class="card mb-0">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-credit-card fa-2x mb-2" style="color: #28a745;"></i>
                                                        <h6 class="mb-0">Kartu Kredit</h6>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" id="eWallet" name="payment_channel" value="E-Wallet" required>
                                            <label class="form-check-label d-block" for="eWallet" style="cursor: pointer;">
                                                <div class="card mb-0">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-wallet fa-2x mb-2" style="color: #ffc107;"></i>
                                                        <h6 class="mb-0">E-Wallet</h6>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" id="cash" name="payment_channel" value="Cash" required>
                                            <label class="form-check-label d-block" for="cash" style="cursor: pointer;">
                                                <div class="card mb-0">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-money-bill fa-2x mb-2" style="color: #dc3545;"></i>
                                                        <h6 class="mb-0">Tunai</h6>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Proof of Payment (Optional) -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <strong>Bukti Pembayaran (Opsional)</strong>
                                </label>
                                <div class="mb-2">
                                    <small class="form-text text-muted">
                                        Format: JPG, PNG | Max: 2 MB
                                    </small>
                                </div>
                                <input type="file" 
                                       class="form-control @error('payment_proof') is-invalid @enderror" 
                                       name="payment_proof" 
                                       accept="image/*">
                                @error('payment_proof')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="termsPayment" required>
                                    <label class="form-check-label" for="termsPayment">
                                        Saya menyetujui bahwa pembayaran ini untuk event yang dipilih
                                    </label>
                                </div>
                            </div>

                            <!-- Button Actions -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check"></i> Proses Pembayaran
                                </button>
                                <a href="{{ route('user.events.show', $order->event->id) }}" 
                                   class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Cara Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="paymentInstructions">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headerBank">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#bankInstructions">
                                        Transfer Bank
                                    </button>
                                </h2>
                                <div id="bankInstructions" class="accordion-collapse collapse" data-bs-parent="#paymentInstructions">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Buka aplikasi banking Anda</li>
                                            <li>Pilih Transfer Antar Bank</li>
                                            <li>Masukkan nomor rekening: <strong>1234567890</strong> (Bank Dummy)</li>
                                            <li>Atas nama: <strong>Event Company</strong></li>
                                            <li>Masukkan nominal sesuai yang tertera</li>
                                            <li>Konfirmasi dan selesaikan transaksi</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headerCard">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cardInstructions">
                                        Kartu Kredit
                                    </button>
                                </h2>
                                <div id="cardInstructions" class="accordion-collapse collapse" data-bs-parent="#paymentInstructions">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Klik tombol "Proses Pembayaran"</li>
                                            <li>Anda akan diarahkan ke halaman gateway pembayaran</li>
                                            <li>Masukkan data kartu kredit Anda</li>
                                            <li>Konfirmasi pembayaran melalui OTP atau verifikasi lainnya</li>
                                            <li>Tunggu konfirmasi pembayaran</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="card-title">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <!-- Event Summary -->
                        <div class="mb-3">
                            <h6 class="text-muted">Event</h6>
                            <p class="mb-0">
                                <strong>{{ $order->event->title }}</strong>
                            </p>
                        </div>

                        <hr>

                        <!-- Pricing Details -->
                        <div class="mb-3">
                            @foreach ($order->orderItems as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $item->ticketType->name }} x{{ $item->quantity }}:</span>
                                    <span class="fw-bold">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <hr>

                            <div class="d-flex justify-content-between">
                                <span class="fs-5"><strong>Total:</strong></span>
                                <span class="fs-5 fw-bold text-primary">
                                    Rp. {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <hr>

                        <!-- Payment Reference -->
                        <div class="alert alert-light">
                            <small class="text-muted">Referensi Pembayaran</small>
                            <p class="mb-0 font-monospace">
                                <strong>{{ $order->payment_reference }}</strong>
                            </p>
                        </div>

                        <!-- Important Notice -->
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Penting!</strong>
                            <p class="mb-0 mt-2">
                                Pembayaran harus diselesaikan dalam <strong>1x24 jam</strong> setelah pendaftaran. Jika belum ada pembayaran, registrasi akan dibatalkan otomatis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ExtraCSS')
<style>
    .payment-method-card .form-check-input {
        display: none;
    }
    
    .payment-method-card .form-check-input:checked + label .card {
        border: 2px solid #007bff;
        background-color: #f8f9ff;
    }
    
    .payment-method-card label {
        margin-bottom: 0;
    }

    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #000;
    }
</style>
@endsection

@section('ExtraJS')
@endsection
