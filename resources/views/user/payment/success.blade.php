@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <div class="page-header">
            <h4 class="page-title">Pembayaran Sukses</h4>
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
                    <a href="#">Pembayaran Sukses</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Success Message -->
                <div class="card border-success">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                        </div>
                        
                        <h2 class="mb-2">Pembayaran Berhasil!</h2>
                        <p class="text-muted fs-5 mb-4">
                            Terima kasih. Registrasi event Anda telah terkonfirmasi.
                        </p>

                        <div class="alert alert-success mb-4">
                            <h6>Konfirmasi Pembayaran Diterima</h6>
                            <p class="mb-0">Event Anda sudah terdaftar dan siap untuk dihadiri.</p>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Details -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Detail Event</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Event</small>
                                    <h6>{{ $registration->event->title }}</h6>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Tanggal</small>
                                    <h6>{{ $registration->event->event_date->format('d F Y') }}</h6>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Waktu</small>
                                    <h6>{{ $registration->event->event_date->format('H:i') }} WIB</h6>
                                </div>
                                <div class="mb-0">
                                    <small class="text-muted">Lokasi</small>
                                    <h6>{{ $registration->event->location }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Detail Pembelian</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Tiket Type</small>
                                    <h6>{{ $registration->ticketType->name }}</h6>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Jumlah</small>
                                    <h6>{{ $registration->quantity }} Tiket</h6>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Total Pembayaran</small>
                                    <h6 class="text-primary">
                                        Rp. {{ number_format($registration->total_price, 0, ',', '.') }}
                                    </h6>
                                </div>
                                <div class="mb-0">
                                    <small class="text-muted">Status Pembayaran</small>
                                    <h6>
                                        <span class="badge bg-success">Terbayar</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Penting</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-barcode text-primary"></i> 
                                    Kode Registrasi
                                </h6>
                                <div class="alert alert-light font-monospace">
                                    <strong>{{ $registration->registration_code }}</strong>
                                </div>
                                <small class="text-muted">
                                    Simpan kode ini untuk check-in pada hari event
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-envelope text-warning"></i> 
                                    Konfirmasi Email
                                </h6>
                                <p class="mb-0">
                                    Bukti registrasi telah dikirim ke email Anda:
                                </p>
                                <p class="text-muted">
                                    <strong>{{ Auth::user()->email }}</strong>
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-download text-success"></i> 
                                    Download E-Ticket
                                </h6>
                                <p class="mb-2">
                                    Unduh tiket elektronik dan bawa saat acara dimulai.
                                </p>
                                <a href="{{ route('user.payment.download-ticket', $registration->id) }}" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Unduh Tiket
                                </a>
                            </div>

                            <div class="col-md-6 mb-0">
                                <h6 class="mb-2">
                                    <i class="fas fa-info-circle text-info"></i> 
                                    Perubahan Data
                                </h6>
                                <p class="mb-0">
                                    Jika perlu mengubah data atau membatalkan, hubungi support kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What's Next -->
                <div class="card mt-4 bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Apa yang Harus Dilakukan Sekarang?</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent border-0 ps-0">
                                <i class="fas fa-check-circle text-success"></i> 
                                Periksa email Anda untuk konfirmasi dan detail event
                            </li>
                            <li class="list-group-item bg-transparent border-0 ps-0">
                                <i class="fas fa-check-circle text-success"></i> 
                                Unduh e-ticket dan simpan dengan baik
                            </li>
                            <li class="list-group-item bg-transparent border-0 ps-0">
                                <i class="fas fa-check-circle text-success"></i> 
                                Tandai tanggal event di kalender Anda
                            </li>
                            <li class="list-group-item bg-transparent border-0 ps-0">
                                <i class="fas fa-check-circle text-success"></i> 
                                Hadir lebih awal agar dapat melalui check-in dengan lancar
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4 mb-4">
                    <div class="col-md-12">
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-home"></i> Kembali ke Dashboard
                            </a>
                            <a href="{{ route('user.events.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-search"></i> Cari Event Lainnya
                            </a>
                            <a href="{{ route('user.payment.history') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-history"></i> Riwayat Pembayaran
                            </a>
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
    // Optional: Print receipt functionality
    function printReceipt() {
        window.print();
    }
</script>
@endsection
