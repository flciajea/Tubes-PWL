@extends('layouts.master')

@section('content')
<style>
    .ev-wrap { padding: 1.5rem 0 3rem; }

    /* Breadcrumb */
    .ev-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #888; margin-bottom: 1.25rem; flex-wrap: wrap; }
    .ev-breadcrumb a { color: #888; text-decoration: none; transition: color .15s; }
    .ev-breadcrumb a:hover { color: #111; }
    .ev-breadcrumb .sep { font-size: 10px; opacity: .5; }

    /* Alerts */
    .ev-alert-danger { background: #fff5f5; border: 1px solid #fecaca; border-radius: 10px; padding: .875rem 1rem; margin-bottom: 1.25rem; }
    .ev-alert-danger strong { font-size: 13px; color: #b91c1c; display: block; margin-bottom: 6px; }
    .ev-alert-danger ul { margin: 0; padding-left: 1.25rem; }
    .ev-alert-danger li { font-size: 13px; color: #dc2626; }
    .ev-alert-danger p { font-size: 13px; color: #dc2626; margin: 0; }

    /* Layout */
    .ev-grid { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start; }
    @media (max-width: 900px) { .ev-grid { grid-template-columns: 1fr; } }

    /* Main card */
    .ev-card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; overflow: hidden; margin-bottom: 1.25rem; }

    /* Banner */
    .ev-banner { width: 100%; height: 360px; object-fit: cover; display: block; }
    .ev-banner-placeholder { width: 100%; height: 360px; background: #f5f5f5; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; color: #bbb; }
    .ev-banner-placeholder i { font-size: 36px; }
    .ev-banner-placeholder span { font-size: 14px; }

    /* Card body */
    .ev-card-body { padding: 1.5rem; }

    /* Title area */
    .ev-category-badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; background: #eff6ff; color: #2563eb; margin-bottom: .625rem; }
    .ev-title { font-size: 24px; font-weight: 700; color: #111; line-height: 1.3; margin-bottom: 1.25rem; }

    /* Meta grid */
    .ev-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: #f0f0f0; border: 1px solid #f0f0f0; border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem; }
    .ev-meta-item { background: #fff; padding: .875rem 1rem; }
    .ev-meta-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #aaa; margin-bottom: 5px; display: flex; align-items: center; gap: 5px; }
    .ev-meta-label i { font-size: 11px; }
    .ev-meta-val { font-size: 14px; font-weight: 500; color: #111; line-height: 1.4; }
    .ev-quota-badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }
    .ev-quota-ok { background: #f0fdf4; color: #15803d; }
    .ev-quota-low { background: #fffbeb; color: #d97706; }

    /* Description */
    .ev-desc-title { font-size: 15px; font-weight: 700; color: #111; margin-bottom: .75rem; display: flex; align-items: center; gap: 8px; }
    .ev-desc-title::after { content: ''; flex: 1; height: 1px; background: #f0f0f0; }
    .ev-desc-body { font-size: 14px; color: #444; line-height: 1.75; }

    /* Sidebar cards */
    .ev-side-card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; overflow: hidden; margin-bottom: 1rem; position: sticky; top: 20px; }
    .ev-side-header { padding: .875rem 1.25rem; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 10px; }
    .ev-side-header-icon { width: 30px; height: 30px; border-radius: 7px; background: #f4f4f4; display: flex; align-items: center; justify-content: center; }
    .ev-side-header-icon i { font-size: 13px; color: #555; }
    .ev-side-header h5 { font-size: 14px; font-weight: 600; color: #111; margin: 0; }
    .ev-side-body { padding: 1.25rem; }

    /* Ticket options in sidebar */
    .ev-ticket-list { display: flex; flex-direction: column; gap: .5rem; margin-bottom: 1rem; }
    .ev-ticket-opt { display: grid; grid-template-columns: 20px 1fr auto; align-items: center; gap: 10px; padding: .75rem .875rem; border: 1.5px solid #ebebeb; border-radius: 9px; cursor: pointer; transition: border-color .15s, background .15s; }
    .ev-ticket-opt:hover { border-color: #93c5fd; background: #f8fbff; }
    .ev-ticket-opt.selected { border-color: #3b82f6; background: #f0f7ff; }
    .ev-ticket-opt input[type=radio] { accent-color: #3b82f6; width: 15px; height: 15px; }
    .ev-ticket-name { font-size: 13px; font-weight: 600; color: #111; }
    .ev-ticket-quota { font-size: 11px; color: #888; margin-top: 2px; }
    .ev-ticket-price { font-size: 13px; font-weight: 700; color: #3b82f6; white-space: nowrap; }
    .ev-ticket-free { color: #16a34a; }

    /* Quota alert */
    .ev-quota-alert { display: flex; align-items: center; gap: 8px; padding: .625rem .875rem; background: #f0f7ff; border: 1px solid #c8e0fb; border-radius: 8px; margin-bottom: 1rem; font-size: 13px; color: #1e40af; }
    .ev-quota-alert i { font-size: 13px; color: #3b82f6; flex-shrink: 0; }
    .ev-quota-alert.hidden { display: none; }

    /* CTA button */
    .btn-ev-primary { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: .75rem 1rem; background: #111; color: #fff; border: none; border-radius: 9px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; transition: opacity .15s; font-family: inherit; }
    .btn-ev-primary:hover { opacity: .85; color: #fff; text-decoration: none; }
    .btn-ev-primary:disabled, .btn-ev-primary.disabled { background: #ccc; cursor: not-allowed; opacity: 1; }

    /* Full alert */
    .ev-full-alert { display: flex; gap: 10px; padding: .875rem 1rem; background: #fff5f5; border: 1px solid #fecaca; border-radius: 9px; }
    .ev-full-alert i { color: #dc2626; font-size: 14px; margin-top: 1px; flex-shrink: 0; }
    .ev-full-alert p { font-size: 13px; color: #991b1b; margin: 0; line-height: 1.5; }

    .ev-warn-alert { display: flex; gap: 10px; padding: .875rem 1rem; background: #fffbeb; border: 1px solid #fde68a; border-radius: 9px; }
    .ev-warn-alert i { color: #d97706; font-size: 14px; margin-top: 1px; flex-shrink: 0; }
    .ev-warn-alert p { font-size: 13px; color: #92400e; margin: 0; line-height: 1.5; }

    /* Info list */
    .ev-info-list { display: flex; flex-direction: column; gap: .625rem; }
    .ev-info-item { display: flex; gap: 10px; align-items: flex-start; }
    .ev-info-item i { font-size: 13px; color: #aaa; margin-top: 2px; flex-shrink: 0; width: 14px; text-align: center; }
    .ev-info-item span { font-size: 13px; color: #555; line-height: 1.5; }

    /* Divider */
    .ev-divider { height: 1px; background: #f0f0f0; margin: 1rem 0; }
</style>

<div class="ev-wrap">
    <div class="page-inner">

        <!-- Breadcrumb -->
        <div class="ev-breadcrumb">
            <a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a>
            <span class="sep">›</span>
            <a href="{{ route('user.events.index') }}">Event</a>
            <span class="sep">›</span>
            <span>{{ $event->title }}</span>
        </div>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="ev-alert-danger">
                <strong><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="ev-alert-danger">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="ev-grid">

            <!-- Left: Main content -->
            <div>
                <div class="ev-card">
                    <!-- Banner -->
                    @if ($event->banner)
                        <img src="{{ asset('storage/' . $event->banner) }}"
                             alt="{{ $event->title }}"
                             class="ev-banner">
                    @else
                        <div class="ev-banner-placeholder">
                            <i class="fas fa-image"></i>
                            <span>No Image Available</span>
                        </div>
                    @endif

                    <div class="ev-card-body">
                        <!-- Category + Title -->
                        <span class="ev-category-badge">{{ $event->category->name }}</span>
                        <h1 class="ev-title">{{ $event->title }}</h1>

                        <!-- Meta grid -->
                        <div class="ev-meta-grid">
                            <div class="ev-meta-item">
                                <div class="ev-meta-label"><i class="fas fa-calendar-alt"></i> Tanggal &amp; Waktu</div>
                                <div class="ev-meta-val">{{ $event->event_date->format('d F Y, H:i') }}</div>
                            </div>
                            <div class="ev-meta-item">
                                <div class="ev-meta-label"><i class="fas fa-map-marker-alt"></i> Lokasi</div>
                                <div class="ev-meta-val">{{ $event->location }}</div>
                            </div>
                            <div class="ev-meta-item">
                                <div class="ev-meta-label"><i class="fas fa-user"></i> Organizer</div>
                                <div class="ev-meta-val">{{ $event->organizer->name }}</div>
                            </div>
                            <div class="ev-meta-item">
                                <div class="ev-meta-label"><i class="fas fa-ticket-alt"></i> Kuota Tersisa</div>
                                <div class="ev-meta-val">
                                    <span class="ev-quota-badge {{ $availableQuota > 10 ? 'ev-quota-ok' : 'ev-quota-low' }}">
                                        {{ $availableQuota }} / {{ $event->total_quota }} tiket
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="ev-desc-title">Deskripsi Event</div>
                        <div class="ev-desc-body">{{ $event->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar -->
            <div>
                <div class="ev-side-card">
                    <div class="ev-side-header">
                        <div class="ev-side-header-icon"><i class="fas fa-ticket-alt"></i></div>
                        <h5>Pilih Tiket</h5>
                    </div>
                    <div class="ev-side-body">

                        @if ($availableQuota <= 0)
                            <div class="ev-full-alert">
                                <i class="fas fa-ban"></i>
                                <p>Event ini sudah penuh dan tidak bisa didaftar.</p>
                            </div>

                        @elseif ($event->ticketTypes->count() > 0)
                            <form action="{{ route('user.events.register', $event->id) }}" method="GET">

                                <div class="ev-ticket-list">
                                    @foreach ($event->ticketTypes as $index => $ticket)
                                        <label class="ev-ticket-opt {{ $index === 0 ? 'selected' : '' }}"
                                               for="ticket_{{ $ticket->id }}">
                                            <input type="radio"
                                                   id="ticket_{{ $ticket->id }}"
                                                   name="ticket_type_id"
                                                   value="{{ $ticket->id }}"
                                                   data-price="{{ $ticket->price }}"
                                                   data-quota="{{ $ticket->remaining_quota }}"
                                                   {{ $index === 0 ? 'checked' : '' }}
                                                   required>
                                            <div>
                                                <div class="ev-ticket-name">{{ $ticket->name }}</div>
                                                <div class="ev-ticket-quota">Sisa: {{ $ticket->remaining_quota }} tiket</div>
                                            </div>
                                            <div class="ev-ticket-price {{ $ticket->price == 0 ? 'ev-ticket-free' : '' }}">
                                                {{ $ticket->price == 0 ? 'Gratis' : 'Rp ' . number_format($ticket->price, 0, ',', '.') }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="ev-quota-alert hidden" id="quotaAlert">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Sisa kuota: <strong id="quotaInfo"></strong></span>
                                </div>

                                <a href="{{ route('user.events.register', $event->id) }}"
                                   class="btn-ev-primary" id="registerBtn">
                                    <i class="fas fa-check"></i> Daftar Sekarang
                                </a>
                            </form>

                        @else
                            <div class="ev-warn-alert">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Tiket belum tersedia untuk event ini.</p>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Info card -->
                <div class="ev-side-card" style="position:static">
                    <div class="ev-side-header">
                        <div class="ev-side-header-icon"><i class="fas fa-info-circle"></i></div>
                        <h5>Informasi</h5>
                    </div>
                    <div class="ev-side-body">
                        <div class="ev-info-list">
                            <div class="ev-info-item">
                                <i class="fas fa-hand-pointer"></i>
                                <span>Pilih tiket yang ingin Anda daftar, lalu klik "Daftar Sekarang" untuk melanjutkan.</span>
                            </div>
                            <div class="ev-divider" style="margin:.25rem 0"></div>
                            <div class="ev-info-item">
                                <i class="fas fa-lock"></i>
                                <span>Pendaftaran akan dikonfirmasi setelah melakukan pembayaran.</span>
                            </div>
                            <div class="ev-divider" style="margin:.25rem 0"></div>
                            <div class="ev-info-item">
                                <i class="fas fa-download"></i>
                                <span>Unduh E-ticket setelah pembayaran berhasil dikonfirmasi.</span>
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
    document.querySelectorAll('.ev-ticket-opt').forEach(function(label) {
        label.addEventListener('click', function() {
            document.querySelectorAll('.ev-ticket-opt').forEach(l => l.classList.remove('selected'));
            this.classList.add('selected');

            var radio = this.querySelector('input[type=radio]');
            var quota = radio ? radio.getAttribute('data-quota') : null;
            var quotaAlert = document.getElementById('quotaAlert');
            var quotaInfo = document.getElementById('quotaInfo');

            if (quota !== null) {
                quotaInfo.textContent = quota + ' tiket';
                quotaAlert.classList.remove('hidden');
            } else {
                quotaAlert.classList.add('hidden');
            }
        });
    });

    // Show quota for default selected on load
    var defaultRadio = document.querySelector('input[name="ticket_type_id"]:checked');
    if (defaultRadio) {
        var quota = defaultRadio.getAttribute('data-quota');
        if (quota !== null) {
            document.getElementById('quotaInfo').textContent = quota + ' tiket';
            document.getElementById('quotaAlert').classList.remove('hidden');
        }
    }
</script>
@endsection