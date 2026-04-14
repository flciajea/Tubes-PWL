@extends('layouts.master')

@section('content')
    <style>
        .pay-wrap {
            padding: 1.5rem 0 3rem;
        }

        /* Breadcrumb */
        .pay-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #888;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .pay-breadcrumb a {
            color: #888;
            text-decoration: none;
            transition: color .15s;
        }

        .pay-breadcrumb a:hover {
            color: #111;
        }

        .pay-breadcrumb .sep {
            font-size: 10px;
            opacity: .5;
        }

        /* Step dots */
        .step-dots {
            display: flex;
            gap: 6px;
            margin-bottom: 1.5rem;
        }

        .step-dot {
            height: 4px;
            border-radius: 2px;
        }

        .step-dot.on {
            background: #111;
            width: 28px;
        }

        .step-dot.off {
            background: #e0e0e0;
            width: 16px;
        }

        .step-dot.done {
            background: #22c55e;
            width: 16px;
        }

        /* Alerts */
        .pay-alert-danger {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: .875rem 1rem;
            margin-bottom: 1.25rem;
        }

        .pay-alert-danger strong {
            font-size: 13px;
            color: #b91c1c;
            display: block;
            margin-bottom: 6px;
        }

        .pay-alert-danger ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .pay-alert-danger li {
            font-size: 13px;
            color: #dc2626;
        }

        .pay-alert-danger p {
            font-size: 13px;
            color: #dc2626;
            margin: 0;
        }

        /* Layout grid */
        .pay-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
            align-items: start;
        }

        @media (max-width: 900px) {
            .pay-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .pay-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        .pay-card-header {
            padding: .875rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pay-card-header-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pay-card-header-icon i {
            font-size: 13px;
            color: #555;
        }

        .pay-card-header h5 {
            font-size: 14px;
            font-weight: 600;
            color: #111;
            margin: 0;
        }

        .pay-card-body {
            padding: 1.25rem;
        }

        /* Event banner info */
        .pay-event-info {
            display: flex;
            gap: 12px;
            padding: .875rem 1rem;
            background: #f0f7ff;
            border: 1px solid #c8e0fb;
            border-radius: 10px;
            margin-bottom: 1.25rem;
        }

        .pay-event-info-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #c8e0fb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pay-event-info-icon i {
            font-size: 14px;
            color: #3b82f6;
        }

        .pay-event-info h6 {
            font-size: 14px;
            font-weight: 600;
            color: #1e40af;
            margin: 0 0 4px;
        }

        .pay-event-info p {
            font-size: 13px;
            color: #3b5f9f;
            margin: 0;
            line-height: 1.6;
        }

        .pay-ref-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            background: #fff;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #1d4ed8;
            margin-top: 5px;
            font-family: monospace;
            letter-spacing: .3px;
        }

        /* Section label */
        .pay-section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #aaa;
            margin-bottom: .875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pay-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f0f0f0;
        }

        /* Payment method grid */
        .pay-method-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .625rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 500px) {
            .pay-method-grid {
                grid-template-columns: 1fr;
            }
        }

        .pay-method-opt input[type=radio] {
            display: none;
        }

        .pay-method-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 1rem .75rem;
            border: 1.5px solid #ebebeb;
            border-radius: 10px;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            text-align: center;
        }

        .pay-method-card:hover {
            border-color: #93c5fd;
            background: #f8fbff;
        }

        .pay-method-opt input[type=radio]:checked+.pay-method-card {
            border-color: #3b82f6;
            background: #f0f7ff;
        }

        .pay-method-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pay-method-icon i {
            font-size: 20px;
        }

        .pay-method-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .pm-blue .pay-method-icon {
            background: #eff6ff;
        }

        .pm-blue .pay-method-icon i {
            color: #3b82f6;
        }

        .pm-green .pay-method-icon {
            background: #f0fdf4;
        }

        .pm-green .pay-method-icon i {
            color: #16a34a;
        }

        .pm-amber .pay-method-icon {
            background: #fffbeb;
        }

        .pm-amber .pay-method-icon i {
            color: #d97706;
        }

        .pm-red .pay-method-icon {
            background: #fff5f5;
        }

        .pm-red .pay-method-icon i {
            color: #dc2626;
        }

        /* File upload */
        .pay-file-area {
            border: 1.5px dashed #d1d5db;
            border-radius: 10px;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            position: relative;
        }

        .pay-file-area:hover {
            border-color: #93c5fd;
            background: #f8fbff;
        }

        .pay-file-area input[type=file] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .pay-file-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }

        .pay-file-icon i {
            font-size: 16px;
            color: #888;
        }

        .pay-file-title {
            font-size: 14px;
            font-weight: 500;
            color: #111;
            margin-bottom: 3px;
        }

        .pay-file-hint {
            font-size: 12px;
            color: #aaa;
        }

        .invalid-feedback {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
            display: block;
        }

        /* Terms */
        .pay-terms-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: .875rem 1rem;
            background: #fafafa;
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            cursor: pointer;
            transition: border-color .15s;
        }

        .pay-terms-box:hover {
            border-color: #93c5fd;
        }

        .pay-terms-box input[type=checkbox] {
            accent-color: #3b82f6;
            width: 16px;
            height: 16px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .pay-terms-box span {
            font-size: 13px;
            color: #555;
            line-height: 1.55;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            padding-top: .25rem;
        }

        .btn-pay-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: .75rem 1.5rem;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .15s;
            font-family: inherit;
        }

        .btn-pay-primary:hover {
            opacity: .85;
            color: #fff;
        }

        .btn-pay-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: .75rem 1.25rem;
            background: transparent;
            color: #555;
            border: 1px solid #e0e0e0;
            border-radius: 9px;
            font-size: 14px;
            cursor: pointer;
            transition: background .15s;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-pay-secondary:hover {
            background: #f5f5f5;
            color: #111;
            text-decoration: none;
        }

        /* Accordion */
        .pay-accordion {
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .pay-acc-item {
            border-bottom: 1px solid #f0f0f0;
        }

        .pay-acc-item:last-child {
            border-bottom: none;
        }

        .pay-acc-btn {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .875rem 1rem;
            background: #fafafa;
            border: none;
            font-size: 13px;
            font-weight: 600;
            color: #111;
            cursor: pointer;
            text-align: left;
            transition: background .15s;
        }

        .pay-acc-btn:hover {
            background: #f0f0f0;
        }

        .pay-acc-btn.open {
            background: #f0f7ff;
            color: #1e40af;
        }

        .pay-acc-btn .acc-icon {
            font-size: 11px;
            color: #aaa;
            transition: transform .2s;
        }

        .pay-acc-btn.open .acc-icon {
            transform: rotate(180deg);
        }

        .pay-acc-body {
            display: none;
            padding: 1rem;
            background: #fff;
        }

        .pay-acc-body.open {
            display: block;
        }

        .pay-acc-body ol {
            padding-left: 1.25rem;
            margin: 0;
        }

        .pay-acc-body ol li {
            font-size: 13px;
            color: #555;
            line-height: 1.7;
        }

        .pay-acc-body ol li strong {
            color: #111;
        }

        /* Summary card */
        .sum-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 14px;
            overflow: hidden;
            position: sticky;
            top: 20px;
        }

        .sum-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .sum-header h5 {
            font-size: 14px;
            font-weight: 600;
            color: #111;
            margin: 0;
        }

        .sum-body {
            padding: 1.25rem;
        }

        .sum-event-name {
            font-size: 15px;
            font-weight: 700;
            color: #111;
            margin-bottom: .75rem;
            line-height: 1.4;
        }

        .sum-divider {
            height: 1px;
            background: #f0f0f0;
            margin: .875rem 0;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .4rem 0;
        }

        .sum-row .sr-label {
            font-size: 13px;
            color: #888;
        }

        .sum-row .sr-val {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .sum-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .875rem 1rem;
            background: #f0f7ff;
            border-radius: 10px;
            margin: .875rem 0;
        }

        .sum-total .st-label {
            font-size: 14px;
            font-weight: 600;
            color: #1e40af;
        }

        .sum-total .st-val {
            font-size: 20px;
            font-weight: 700;
            color: #3b82f6;
        }

        .sum-ref {
            padding: .75rem 1rem;
            background: #fafafa;
            border: 1px solid #f0f0f0;
            border-radius: 9px;
            margin-bottom: .75rem;
        }

        .sum-ref .sr-label2 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #aaa;
            margin-bottom: 4px;
        }

        .sum-ref .sr-code {
            font-size: 13px;
            font-weight: 700;
            color: #111;
            font-family: monospace;
            letter-spacing: .5px;
        }

        .sum-warn {
            display: flex;
            gap: 10px;
            padding: .75rem 1rem;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 9px;
        }

        .sum-warn i {
            color: #d97706;
            font-size: 13px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .sum-warn p {
            font-size: 12px;
            color: #92400e;
            line-height: 1.55;
            margin: 0;
        }
    </style>

    <div class="pay-wrap">
        <div class="page-inner">

            <!-- Breadcrumb -->
            <div class="pay-breadcrumb">
                <a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a>
                <span class="sep">›</span>
                <span>Pembayaran</span>
            </div>

            <!-- Step dots -->
            <div class="step-dots">
                <div class="step-dot done"></div>
                <div class="step-dot on"></div>
                <div class="step-dot off"></div>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="pay-alert-danger">
                    <strong><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="pay-alert-danger">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="pay-grid">

                <!-- Left: Form -->
                <div>
                    <div class="pay-card">
                        <div class="pay-card-header">
                            <div class="pay-card-header-icon"><i class="fas fa-credit-card"></i></div>
                            <h5>Detail Pembayaran</h5>
                        </div>
                        <div class="pay-card-body">

                            <!-- Event info -->
                            <div class="pay-event-info">
                                <div class="pay-event-info-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <h6>{{ $order->event->title }}</h6>
                                    <p>
                                        @foreach ($order->orderItems as $item)
                                            <i class="fas fa-ticket-alt"></i> {{ $item->ticketType->name }} &times;
                                            {{ $item->quantity }}<br>
                                        @endforeach
                                    </p>
                                    <div class="pay-ref-pill">
                                        <i class="fas fa-barcode"></i> {{ $order->payment_reference }}
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('user.payment.process', $order->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Payment methods -->
                                <div class="pay-section-label">Metode pembayaran</div>
                                <div class="pay-method-grid">
                                    <label class="pay-method-opt pm-blue">
                                        <input type="radio" name="payment_channel" value="Bank Transfer" required>
                                        <div class="pay-method-card">
                                            <div class="pay-method-icon"><i class="fas fa-university"></i></div>
                                            <div class="pay-method-name">Transfer Bank</div>
                                        </div>
                                    </label>
                                    <label class="pay-method-opt pm-green">
                                        <input type="radio" name="payment_channel" value="Credit Card" required>
                                        <div class="pay-method-card">
                                            <div class="pay-method-icon"><i class="fas fa-credit-card"></i></div>
                                            <div class="pay-method-name">Kartu Kredit</div>
                                        </div>
                                    </label>
                                    <label class="pay-method-opt pm-amber">
                                        <input type="radio" name="payment_channel" value="E-Wallet" required>
                                        <div class="pay-method-card">
                                            <div class="pay-method-icon"><i class="fas fa-wallet"></i></div>
                                            <div class="pay-method-name">E-Wallet</div>
                                        </div>
                                    </label>
                                    <label class="pay-method-opt pm-red">
                                        <input type="radio" name="payment_channel" value="Cash" required>
                                        <div class="pay-method-card">
                                            <div class="pay-method-icon"><i class="fas fa-money-bill-wave"></i></div>
                                            <div class="pay-method-name">Tunai</div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Proof of payment -->
                                <div class="pay-section-label" style="margin-top:1.25rem">Bukti pembayaran <span
                                        style="font-weight:400;font-size:11px;color:#bbb;text-transform:none;letter-spacing:0">(opsional)</span>
                                </div>
                                <div class="pay-file-area" id="fileArea">
                                    <input type="file" name="payment_proof" accept="image/*" id="proofInput"
                                        onchange="updateFileName(this)">

                                    <img id="imagePreview" src=""
                                        style="display:none; max-width: 150px; margin: 10px auto; border-radius: 8px; border: 1px solid #ddd;">

                                    <div class="pay-file-icon"><i class="fas fa-upload" id="fileIcon"></i></div>
                                    <div class="pay-file-title" id="fileTitle">Klik untuk upload bukti transfer</div>
                                    <div class="pay-file-hint">JPG, PNG — maks. 2 MB</div>
                                </div>
                                @error('payment_proof')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Terms -->
                                <div style="margin-top:1.25rem">
                                    <label class="pay-terms-box" for="termsPayment">
                                        <input type="checkbox" id="termsPayment" required>
                                        <span>Saya menyetujui bahwa pembayaran ini untuk event yang dipilih.</span>
                                    </label>
                                </div>

                                <!-- Actions -->
                                <div class="btn-row" style="margin-top:1.25rem">
                                    <button type="submit" class="btn-pay-primary">
                                        <i class="fas fa-check"></i> Proses Pembayaran
                                    </button>
                                    <a href="{{ route('user.events.show', $order->event->id) }}" class="btn-pay-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- Instructions accordion -->
                    <div class="pay-card">
                        <div class="pay-card-header">
                            <div class="pay-card-header-icon"><i class="fas fa-question-circle"></i></div>
                            <h5>Cara Pembayaran</h5>
                        </div>
                        <div class="pay-card-body" style="padding:0">
                            <div class="pay-accordion">
                                <div class="pay-acc-item">
                                    <button class="pay-acc-btn" type="button" onclick="toggleAcc(this)">
                                        <span><i class="fas fa-university"
                                                style="margin-right:8px;color:#3b82f6"></i>Transfer Bank</span>
                                        <i class="fas fa-chevron-down acc-icon"></i>
                                    </button>
                                    <div class="pay-acc-body">
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
                                <div class="pay-acc-item">
                                    <button class="pay-acc-btn" type="button" onclick="toggleAcc(this)">
                                        <span><i class="fas fa-credit-card"
                                                style="margin-right:8px;color:#16a34a"></i>Kartu Kredit</span>
                                        <i class="fas fa-chevron-down acc-icon"></i>
                                    </button>
                                    <div class="pay-acc-body">
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

                <!-- Right: Summary -->
                <div>
                    <div class="sum-card">
                        <div class="sum-header">
                            <h5><i class="fas fa-receipt" style="margin-right:6px;color:#aaa"></i>Ringkasan Pesanan</h5>
                        </div>
                        <div class="sum-body">

                            <div class="sum-event-name">{{ $order->event->title }}</div>
                            <div class="sum-divider"></div>

                            @foreach ($order->orderItems as $item)
                                <div class="sum-row">
                                    <span class="sr-label">{{ $item->ticketType->name }}
                                        &times;{{ $item->quantity }}</span>
                                    <span class="sr-val">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <div class="sum-total">
                                <span class="st-label">Total</span>
                                <span class="st-val">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>

                            <div class="sum-ref">
                                <div class="sr-label2">Referensi Pembayaran</div>
                                <div class="sr-code">{{ $order->payment_reference }}</div>
                            </div>

                            <div class="sum-warn">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Pembayaran harus diselesaikan dalam <strong>1×24 jam</strong>. Jika belum dibayar,
                                    registrasi akan dibatalkan otomatis.</p>
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
        function toggleAcc(btn) {
            var body = btn.nextElementSibling;
            var isOpen = body.classList.contains('open');
            document.querySelectorAll('.pay-acc-body').forEach(b => b.classList.remove('open'));
            document.querySelectorAll('.pay-acc-btn').forEach(b => b.classList.remove('open'));
            if (!isOpen) {
                body.classList.add('open');
                btn.classList.add('open');
            }
        }

        function updateFileName(input) {
            var title = document.getElementById('fileTitle');
            var icon = document.getElementById('fileIcon');
            var area = document.getElementById('fileArea');
            var preview = document.getElementById('imagePreview'); // Ambil elemen img

            if (input.files && input.files[0]) {
                // Tampilkan Nama File
                title.textContent = input.files[0].name;
                icon.className = 'fas fa-check-circle';
                icon.style.color = '#16a34a';
                area.style.borderColor = '#86efac';
                area.style.background = '#f0fdf4';

                // LOGIKA PREVIEW GAMBAR
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Munculkan gambar
                    icon.style.display = 'none'; // Sembunyikan icon upload agar rapi
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
