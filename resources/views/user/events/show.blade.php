@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <div class="page-header">
            <h4 class="page-title">Detail Event</h4>
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
            <!-- Event Image and Info -->
            <div class="col-lg-8">
                <div class="card">
                    <!-- Banner Image -->
                    <div class="position-relative overflow-hidden" style="height: 400px;">
                        @if ($event->banner)
                            <img src="{{ asset('storage/' . $event->banner) }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center w-100 h-100">
                                <span class="text-white">No Image Available</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <!-- Title and Category -->
                        <div class="mb-3">
                            <span class="badge bg-primary mb-2">{{ $event->category->name }}</span>
                            <h2 class="card-title">{{ $event->title }}</h2>
                        </div>

                        <!-- Event Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar-alt"></i> 
                                    <strong>Tanggal & Waktu</strong>
                                </p>
                                <p>{{ $event->event_date->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <strong>Lokasi</strong>
                                </p>
                                <p>{{ $event->location }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-2">
                                    <i class="fas fa-user"></i> 
                                    <strong>Organizer</strong>
                                </p>
                                <p>{{ $event->organizer->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-2">
                                    <i class="fas fa-ticket-alt"></i> 
                                    <strong>Quota Tersisa</strong>
                                </p>
                                <p>
                                    <span class="badge bg-{{ $availableQuota > 10 ? 'success' : 'warning' }}">
                                        {{ $availableQuota }} / {{ $event->total_quota }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5>Deskripsi Event</h5>
                            <p class="text-justify">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Ticket Types and Registration -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pilih Tiket</h5>
                    </div>
                    <div class="card-body">
                        @if ($availableQuota <= 0)
                            <div class="alert alert-danger">
                                Event ini sudah penuh dan tidak bisa didaftar.
                            </div>
                        @else
                            @if ($event->ticketTypes->count() > 0)
                                <form action="{{ route('user.events.register', $event->id) }}" method="GET">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Tiket</label>
                                        <select name="ticket_type_id" class="form-select" id="ticketTypeSelect" required>
                                            <option value="">-- Pilih Tiket --</option>
                                            @foreach ($event->ticketTypes as $ticket)
                                                <option value="{{ $ticket->id }}" 
                                                        data-price="{{ $ticket->price }}"
                                                        data-quota="{{ $ticket->remaining_quota }}">
                                                    {{ $ticket->name }} - Rp. {{ number_format($ticket->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="alert alert-info d-none" id="quotaAlert" role="alert">
                                        Sisa Quota: <strong id="quotaInfo"></strong>
                                    </div>

                                    <a href="{{ route('user.events.register', $event->id) }}" 
                                       class="btn btn-primary w-100">
                                        Daftar Sekarang
                                    </a>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    Tiket belum tersedia untuk event ini.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Quick Info Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Informasi</h5>
                    </div>
                    <div class="card-body small">
                        <p class="mb-2">
                            <i class="fas fa-info-circle"></i> 
                            Pilih tiket yang ingin Anda daftar, lalu klik "Daftar Sekarang" untuk melanjutkan.
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-lock"></i> 
                            Pendaftaran akan dikonfirmasi setelah melakukan pembayaran.
                        </p>
                        <p>
                            <i class="fas fa-download"></i> 
                            Unduh E-ticket setelah pembayaran berhasil.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ExtraJS')
<script>
    document.getElementById('ticketTypeSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const quota = selectedOption.getAttribute('data-quota');
        const quotaAlert = document.getElementById('quotaAlert');
        const quotaInfo = document.getElementById('quotaInfo');
        
        if (quota) {
            quotaInfo.textContent = quota + ' tiket';
            quotaAlert.classList.remove('d-none');
        } else {
            quotaAlert.classList.add('d-none');
        }
    });
</script>
@endsection
