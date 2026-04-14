@extends('layouts.master')

@section('content')
<style>
    .reg-wrap { padding: 1.5rem 0 3rem; }

    /* Breadcrumb */
    .reg-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #888; margin-bottom: 1.25rem; flex-wrap: wrap; }
    .reg-breadcrumb a { color: #888; text-decoration: none; transition: color .15s; }
    .reg-breadcrumb a:hover { color: #111; }
    .reg-breadcrumb .sep { font-size: 10px; opacity: .5; }

    /* Page title */
    .reg-title { font-size: 22px; font-weight: 600; color: #111; margin-bottom: .25rem; }
    .reg-subtitle { font-size: 14px; color: #888; margin-bottom: 1.75rem; }

    /* Step dots */
    .step-dots { display: flex; gap: 6px; margin-bottom: 1.5rem; }
    .step-dot { height: 4px; border-radius: 2px; }
    .step-dot.on { background: #111; width: 28px; }
    .step-dot.off { background: #e0e0e0; width: 16px; }

    /* Layout grid */
    .reg-grid { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start; }
    @media (max-width: 900px) { .reg-grid { grid-template-columns: 1fr; } }

    /* Cards */
    .reg-card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; overflow: hidden; margin-bottom: 1.25rem; }
    .reg-card-header { padding: .875rem 1.25rem; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 10px; }
    .reg-card-header-icon { width: 32px; height: 32px; border-radius: 8px; background: #f4f4f4; display: flex; align-items: center; justify-content: center; }
    .reg-card-header-icon i { font-size: 14px; color: #555; }
    .reg-card-header h5 { font-size: 14px; font-weight: 600; color: #111; margin: 0; }
    .reg-card-body { padding: 1.25rem; }

    /* Alerts */
    .reg-alert-info { background: #f0f7ff; border: 1px solid #c8e0fb; border-radius: 10px; padding: .875rem 1rem; margin-bottom: 1.25rem; display: flex; gap: 12px; align-items: flex-start; }
    .reg-alert-info i { color: #3b82f6; font-size: 15px; margin-top: 2px; flex-shrink: 0; }
    .reg-alert-info h6 { font-size: 14px; font-weight: 600; color: #1e40af; margin: 0 0 4px; }
    .reg-alert-info p { font-size: 13px; color: #3b5f9f; margin: 0; line-height: 1.5; }

    .reg-alert-danger { background: #fff5f5; border: 1px solid #fecaca; border-radius: 10px; padding: .875rem 1rem; margin-bottom: 1.25rem; }
    .reg-alert-danger strong { font-size: 13px; color: #b91c1c; display: block; margin-bottom: 6px; }
    .reg-alert-danger ul { margin: 0; padding-left: 1.25rem; }
    .reg-alert-danger li { font-size: 13px; color: #dc2626; }

    /* Section divider */
    .reg-section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #aaa; margin-bottom: .875rem; padding-bottom: .5rem; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 6px; }

    /* Ticket options */
    .ticket-options { display: flex; flex-direction: column; gap: .5rem; margin-bottom: 0; }
    .ticket-option { display: grid; grid-template-columns: 20px 1fr auto; align-items: center; gap: 12px; padding: .875rem 1rem; border: 1.5px solid #ebebeb; border-radius: 10px; cursor: pointer; transition: border-color .15s, background .15s; }
    .ticket-option:hover { border-color: #93c5fd; background: #f8fbff; }
    .ticket-option.selected { border-color: #3b82f6; background: #f0f7ff; }
    .ticket-option input[type=radio] { accent-color: #3b82f6; width: 16px; height: 16px; }
    .ticket-option-name { font-size: 14px; font-weight: 600; color: #111; }
    .ticket-option-desc { font-size: 12px; color: #888; margin-top: 2px; }
    .ticket-option-price { font-size: 14px; font-weight: 700; color: #3b82f6; white-space: nowrap; }
    .ticket-badge { display: inline-block; padding: 2px 7px; border-radius: 5px; font-size: 10px; font-weight: 700; margin-left: 5px; background: #fef9c3; color: #a16207; }
    .invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 4px; display: block; }

    /* Quantity control */
    .qty-wrap { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .qty-control { display: flex; align-items: center; }
    .qty-btn { width: 36px; height: 36px; border: 1px solid #e0e0e0; background: #f9f9f9; color: #111; font-size: 18px; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .15s; user-select: none; }
    .qty-btn:hover { background: #f0f0f0; }
    .qty-btn.left { border-radius: 8px 0 0 8px; border-right: none; }
    .qty-btn.right { border-radius: 0 8px 8px 0; border-left: none; }
    .qty-input { width: 60px; height: 36px; border: 1px solid #e0e0e0; border-radius: 0; text-align: center; font-size: 15px; font-weight: 600; color: #111; background: #fff; appearance: none; -moz-appearance: textfield; }
    .qty-input:focus { outline: none; border-color: #93c5fd; }
    .qty-input::-webkit-inner-spin-button, .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }
    .qty-hint { font-size: 12px; color: #888; }
    .qty-hint strong { color: #111; }

    /* User data fields */
    .user-data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
    @media (max-width: 500px) { .user-data-grid { grid-template-columns: 1fr; } }
    .user-data-field { background: #fafafa; border: 1px solid #f0f0f0; border-radius: 8px; padding: .625rem .875rem; }
    .user-data-field .udf-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #aaa; margin-bottom: 3px; }
    .user-data-field .udf-val { font-size: 14px; font-weight: 500; color: #111; }
    .user-data-field.full { grid-column: span 2; }

    /* Terms */
    .terms-box { display: flex; align-items: flex-start; gap: 10px; padding: .875rem 1rem; background: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px; cursor: pointer; transition: border-color .15s; }
    .terms-box:hover { border-color: #93c5fd; }
    .terms-box input[type=checkbox] { accent-color: #3b82f6; width: 16px; height: 16px; margin-top: 2px; flex-shrink: 0; cursor: pointer; }
    .terms-box span { font-size: 13px; color: #555; line-height: 1.55; }

    /* Buttons */
    .btn-row { display: flex; gap: .75rem; flex-wrap: wrap; padding-top: .5rem; }
    .btn-reg-primary { display: inline-flex; align-items: center; gap: 8px; padding: .625rem 1.375rem; background: #111; color: #fff; border: none; border-radius: 9px; font-size: 14px; font-weight: 600; cursor: pointer; transition: opacity .15s; text-decoration: none; font-family: inherit; }
    .btn-reg-primary:hover { opacity: .85; color: #fff; text-decoration: none; }
    .btn-reg-secondary { display: inline-flex; align-items: center; gap: 8px; padding: .625rem 1.25rem; background: transparent; color: #555; border: 1px solid #e0e0e0; border-radius: 9px; font-size: 14px; cursor: pointer; transition: background .15s; text-decoration: none; font-family: inherit; }
    .btn-reg-secondary:hover { background: #f5f5f5; color: #111; text-decoration: none; }

    /* Summary card */
    .summary-card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; overflow: hidden; position: sticky; top: 20px; }
    .summary-card-header { padding: 1rem 1.25rem; border-bottom: 1px solid #f0f0f0; }
    .summary-card-header h5 { font-size: 14px; font-weight: 600; color: #111; margin: 0; }
    .summary-card-body { padding: 1.25rem; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; padding: .5rem 0; border-bottom: 1px solid #f5f5f5; }
    .summary-row:last-of-type { border-bottom: none; }
    .summary-row .sr-label { font-size: 13px; color: #888; }
    .summary-row .sr-val { font-size: 13px; font-weight: 600; color: #111; }
    .summary-total-box { display: flex; justify-content: space-between; align-items: center; margin: .75rem 0; padding: 1rem; background: #f0f7ff; border-radius: 10px; }
    .summary-total-box .st-label { font-size: 14px; font-weight: 600; color: #1e40af; }
    .summary-total-box .st-val { font-size: 20px; font-weight: 700; color: #3b82f6; }
    .summary-warn { display: flex; gap: 10px; padding: .75rem; background: #fffbeb; border: 1px solid #fde68a; border-radius: 9px; margin-top: .5rem; }
    .summary-warn i { color: #d97706; font-size: 13px; margin-top: 1px; flex-shrink: 0; }
    .summary-warn p { font-size: 12px; color: #92400e; line-height: 1.5; margin: 0; }
</style>

<div class="reg-wrap">
    <div class="page-inner">

        <!-- Breadcrumb -->
        <div class="reg-breadcrumb">
            <a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a>
            <span class="sep">›</span>
            <a href="{{ route('user.events.index') }}">Event</a>
            <span class="sep">›</span>
            <a href="{{ route('user.events.show', $event->id) }}">{{ $event->title }}</a>
            <span class="sep">›</span>
            <span>Daftar</span>
        </div>

        <!-- Step dots -->
        <div class="step-dots">
            <div class="step-dot on"></div>
            <div class="step-dot off"></div>
            <div class="step-dot off"></div>
        </div>

        <h1 class="reg-title">Daftar Event</h1>
        <p class="reg-subtitle">Lengkapi formulir berikut untuk melanjutkan ke pembayaran</p>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="reg-alert-danger">
                <strong><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="reg-alert-danger">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif

        <div class="reg-grid">

            <!-- Left: Form -->
            <div>
                <form action="{{ route('user.events.store', $event->id) }}" method="POST" id="regForm">
                    @csrf

                    <!-- Event info banner -->
                    <div class="reg-card">
                        <div class="reg-card-body">
                            <div class="reg-alert-info" style="margin-bottom:0">
                                <i class="fas fa-calendar-alt"></i>
                                <div>
                                    <h6>{{ $event->title }}</h6>
                                    <p>
                                        <i class="fas fa-clock"></i> {{ $event->event_date->format('d F Y, H:i') }}
                                        &nbsp;•&nbsp;
                                        <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket type -->
                    <div class="reg-card">
                        <div class="reg-card-header">
                            <div class="reg-card-header-icon"><i class="fas fa-ticket-alt"></i></div>
                            <h5>Pilih Jenis Tiket</h5>
                        </div>
                        <div class="reg-card-body">
                            <div class="ticket-options">
                                @foreach ($event->ticketTypes as $index => $ticket)
                                    <label class="ticket-option {{ old('ticket_type_id', '') == $ticket->id || $index === 0 && !old('ticket_type_id') ? 'selected' : '' }}"
                                           for="ticket_{{ $ticket->id }}">
                                        <input type="radio"
                                               id="ticket_{{ $ticket->id }}"
                                               name="ticket_type_id"
                                               value="{{ $ticket->id }}"
                                               data-price="{{ $ticket->price }}"
                                               data-name="{{ $ticket->name }}"
                                               {{ old('ticket_type_id', $index === 0 ? $ticket->id : '') == $ticket->id ? 'checked' : '' }}
                                               required>
                                        <div>
                                            <div class="ticket-option-name">{{ $ticket->name }}</div>
                                            @if($ticket->description)
                                                <div class="ticket-option-desc">{{ $ticket->description }}</div>
                                            @endif
                                        </div>
                                        <div class="ticket-option-price">
                                            @if($ticket->price == 0)
                                                <span style="color:#16a34a">Gratis</span>
                                            @else
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('ticket_type_id')
                                <div class="invalid-feedback mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="reg-card">
                        <div class="reg-card-header">
                            <div class="reg-card-header-icon"><i class="fas fa-sort-numeric-up"></i></div>
                            <h5>Jumlah Tiket</h5>
                        </div>
                        <div class="reg-card-body">
                            <div class="qty-wrap">
                                <div class="qty-control">
                                    <button type="button" class="qty-btn left" onclick="changeQty(-1)">−</button>
                                    <input type="number"
                                           class="qty-input @error('quantity') is-invalid @enderror"
                                           id="quantity"
                                           name="quantity"
                                           min="1"
                                           max="{{ $availableQuota }}"
                                           value="{{ old('quantity', 1) }}"
                                           required>
                                    <button type="button" class="qty-btn right" onclick="changeQty(1)">+</button>
                                </div>
                                <p class="qty-hint">Kuota tersisa: <strong>{{ $availableQuota }} tiket</strong></p>
                            </div>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- User data -->
                    <div class="reg-card">
                        <div class="reg-card-header">
                            <div class="reg-card-header-icon"><i class="fas fa-user"></i></div>
                            <h5>Data Pemesan</h5>
                        </div>
                        <div class="reg-card-body">
                            <div class="user-data-grid">
                                <div class="user-data-field">
                                    <div class="udf-label">Nama</div>
                                    <div class="udf-val">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="user-data-field">
                                    <div class="udf-label">Email</div>
                                    <div class="udf-val">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="user-data-field full">
                                    <div class="udf-label">Nomor Telepon</div>
                                    <div class="udf-val">{{ Auth::user()->phone ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="reg-card">
                        <div class="reg-card-body">
                            <label class="terms-box" for="termsCheck">
                                <input type="checkbox" id="termsCheck" required>
                                <span>Saya menyetujui syarat dan ketentuan pendaftaran event ini dan bersedia mematuhi seluruh aturan yang berlaku.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="btn-row">
                        <button type="submit" class="btn-reg-primary">
                            <i class="fas fa-check"></i> Lanjutkan ke Pembayaran
                        </button>
                        <a href="{{ route('user.events.show', $event->id) }}" class="btn-reg-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>

            <!-- Right: Summary -->
            <div>
                <div class="summary-card">
                    <div class="summary-card-header">
                        <h5><i class="fas fa-receipt" style="margin-right:6px;color:#aaa"></i>Ringkasan Pesanan</h5>
                    </div>
                    <div class="summary-card-body">
                        <div class="summary-row">
                            <span class="sr-label">Jenis tiket</span>
                            <span class="sr-val" id="summaryTicket">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="sr-label">Harga satuan</span>
                            <span class="sr-val" id="summaryPrice">Rp 0</span>
                        </div>
                        <div class="summary-row">
                            <span class="sr-label">Jumlah</span>
                            <span class="sr-val" id="summaryQty">0</span>
                        </div>
                        <div class="summary-total-box">
                            <span class="st-label">Total harga</span>
                            <span class="st-val" id="summaryTotal">Rp 0</span>
                        </div>
                        <div class="summary-warn">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Pembayaran harus diselesaikan dalam <strong>1×24 jam</strong> setelah mendaftar.</p>
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
    const priceMap = {
        @foreach ($event->ticketTypes as $ticket)
            '{{ $ticket->id }}': {{ $ticket->price }},
        @endforeach
    };

    const maxQty = {{ $availableQuota }};

    // Ticket option click
    document.querySelectorAll('.ticket-option').forEach(function(label) {
        label.addEventListener('click', function() {
            document.querySelectorAll('.ticket-option').forEach(l => l.classList.remove('selected'));
            this.classList.add('selected');
            updateSummary();
        });
    });

    document.getElementById('quantity').addEventListener('input', updateSummary);

    function changeQty(delta) {
        var inp = document.getElementById('quantity');
        var val = (parseInt(inp.value) || 1) + delta;
        if (val < 1) val = 1;
        if (val > maxQty) val = maxQty;
        inp.value = val;
        updateSummary();
    }

    function fmt(n) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    }

    function updateSummary() {
        var checked = document.querySelector('input[name="ticket_type_id"]:checked');
        var ticketName = '-';
        var price = 0;

        if (checked) {
            ticketName = checked.getAttribute('data-name') || checked.closest('.ticket-option').querySelector('.ticket-option-name').textContent.trim();
            price = priceMap[checked.value] || 0;
        }

        var quantity = parseInt(document.getElementById('quantity').value) || 0;
        var total = price * quantity;

        document.getElementById('summaryTicket').textContent = ticketName;
        document.getElementById('summaryPrice').textContent = price === 0 ? 'Gratis' : fmt(price);
        document.getElementById('summaryQty').textContent = quantity;
        document.getElementById('summaryTotal').textContent = total === 0 ? 'Gratis' : fmt(total);
    }

    updateSummary();
</script>
@endsection