@extends('layouts.master')

@section('content')
<style>
    .suc-wrap { padding: 2rem 0 3rem; }
    .suc-center { max-width: 780px; margin: 0 auto; }

    /* Breadcrumb */
    .suc-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #888; margin-bottom: 2rem; flex-wrap: wrap; }
    .suc-breadcrumb a { color: #888; text-decoration: none; transition: color .15s; }
    .suc-breadcrumb a:hover { color: #111; }
    .suc-breadcrumb .sep { font-size: 10px; opacity: .5; }

    /* Step dots */
    .step-dots { display: flex; gap: 6px; margin-bottom: 2rem; }
    .step-dot { height: 4px; border-radius: 2px; }
    .step-dot.done { background: #22c55e; width: 28px; }
    .step-dot.off { background: #e0e0e0; width: 16px; }

    /* Hero success */
    .suc-hero { background: #fff; border: 1px solid #ebebeb; border-radius: 16px; padding: 2.5rem 2rem; text-align: center; margin-bottom: 1.25rem; position: relative; overflow: hidden; }
    .suc-hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #22c55e, #16a34a); }
    .suc-icon-wrap { width: 72px; height: 72px; border-radius: 50%; background: #f0fdf4; border: 2px solid #bbf7d0; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .suc-icon-wrap i { font-size: 30px; color: #22c55e; }
    .suc-hero h1 { font-size: 24px; font-weight: 700; color: #111; margin-bottom: .5rem; }
    .suc-hero p { font-size: 15px; color: #666; margin-bottom: 1.5rem; }
    .suc-conf-pill { display: inline-flex; align-items: center; gap: 8px; padding: .5rem 1.125rem; background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; font-size: 13px; color: #15803d; font-weight: 500; }
    .suc-conf-pill i { font-size: 13px; color: #22c55e; }

    /* Cards */
    .suc-card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; overflow: hidden; margin-bottom: 1.25rem; }
    .suc-card-header { padding: .875rem 1.25rem; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 10px; }
    .suc-card-icon { width: 30px; height: 30px; border-radius: 7px; background: #f4f4f4; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .suc-card-icon i { font-size: 12px; color: #555; }
    .suc-card-header h5 { font-size: 14px; font-weight: 600; color: #111; margin: 0; }
    .suc-card-body { padding: 1.25rem; }

    /* Detail grid */
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
    @media (max-width: 600px) { .detail-grid { grid-template-columns: 1fr; } }

    /* Fields */
    .field-list { display: flex; flex-direction: column; gap: .875rem; }
    .field-item { display: flex; flex-direction: column; gap: 3px; }
    .field-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #bbb; }
    .field-val { font-size: 14px; font-weight: 600; color: #111; line-height: 1.4; }
    .field-val.accent { color: #3b82f6; }
    .field-divider { height: 1px; background: #f5f5f5; }
    .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; background: #f0fdf4; color: #15803d; }
    .status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }

    /* Registration code */
    .reg-code-box { background: #fafafa; border: 1.5px dashed #e0e0e0; border-radius: 10px; padding: 1rem 1.25rem; text-align: center; margin-bottom: .625rem; }
    .reg-code-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #aaa; margin-bottom: 6px; }
    .reg-code-val { font-size: 22px; font-weight: 700; font-family: monospace; color: #111; letter-spacing: 2px; }
    .reg-code-hint { font-size: 12px; color: #aaa; margin-top: 4px; }

    /* Info grid */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 600px) { .info-grid { grid-template-columns: 1fr; } }
    .info-item { padding: 1rem; background: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px; }
    .info-item-header { display: flex; align-items: center; gap: 8px; margin-bottom: .625rem; }
    .info-item-header .ii-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .info-item-header .ii-icon i { font-size: 13px; }
    .info-item-header h6 { font-size: 13px; font-weight: 600; color: #111; margin: 0; }
    .info-item p { font-size: 13px; color: #666; margin: 0; line-height: 1.55; }
    .info-item strong { color: #111; }

    .ii-blue .ii-icon { background: #eff6ff; }
    .ii-blue .ii-icon i { color: #3b82f6; }
    .ii-amber .ii-icon { background: #fffbeb; }
    .ii-amber .ii-icon i { color: #d97706; }
    .ii-green .ii-icon { background: #f0fdf4; }
    .ii-green .ii-icon i { color: #16a34a; }
    .ii-gray .ii-icon { background: #f4f4f4; }
    .ii-gray .ii-icon i { color: #888; }

    /* Download button */
    .btn-dl { display: inline-flex; align-items: center; gap: 7px; padding: .5rem 1rem; background: #111; color: #fff; border: none; border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none; transition: opacity .15s; margin-top: .625rem; }
    .btn-dl:hover { opacity: .85; color: #fff; text-decoration: none; }

    /* Action buttons */
    .action-grid { display: flex; gap: .75rem; flex-wrap: wrap; margin-top: 1.5rem; }
    .btn-act-primary { display: inline-flex; align-items: center; gap: 8px; padding: .75rem 1.375rem; background: #111; color: #fff; border: none; border-radius: 9px; font-size: 14px; font-weight: 600; text-decoration: none; transition: opacity .15s; }
    .btn-act-primary:hover { opacity: .85; color: #fff; text-decoration: none; }
    .btn-act-outline { display: inline-flex; align-items: center; gap: 8px; padding: .75rem 1.25rem; background: transparent; color: #555; border: 1px solid #e0e0e0; border-radius: 9px; font-size: 14px; text-decoration: none; transition: background .15s; }
    .btn-act-outline:hover { background: #f5f5f5; color: #111; text-decoration: none; }

    /* Confetti dots decoration */
    .confetti-row { display: flex; justify-content: center; gap: 5px; margin-bottom: 1.25rem; }
    .confetti-dot { width: 8px; height: 8px; border-radius: 50%; }
</style>

<div class="suc-wrap">
    <div class="page-inner">
        <div class="suc-center">

            <!-- Breadcrumb -->
            <div class="suc-breadcrumb">
                <a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a>
                <span class="sep">›</span>
                <span>Pembayaran Sukses</span>
            </div>

            <!-- Step dots — all done -->
            <div class="step-dots">
                <div class="step-dot done"></div>
                <div class="step-dot done"></div>
                <div class="step-dot done"></div>
            </div>

            <!-- Hero -->
            <div class="suc-hero">
                <div class="confetti-row">
                    <div class="confetti-dot" style="background:#22c55e"></div>
                    <div class="confetti-dot" style="background:#3b82f6"></div>
                    <div class="confetti-dot" style="background:#f59e0b"></div>
                    <div class="confetti-dot" style="background:#22c55e"></div>
                    <div class="confetti-dot" style="background:#ec4899"></div>
                    <div class="confetti-dot" style="background:#3b82f6"></div>
                    <div class="confetti-dot" style="background:#22c55e"></div>
                </div>
                <div class="suc-icon-wrap">
                    <i class="fas fa-check"></i>
                </div>
                <h1>Pembayaran Berhasil!</h1>
                <p>Terima kasih. Registrasi event Anda telah terkonfirmasi.</p>
                <div class="suc-conf-pill">
                    <i class="fas fa-check-circle"></i>
                    Konfirmasi pembayaran diterima — event Anda siap untuk dihadiri
                </div>
            </div>

            <!-- Kode Registrasi -->
            <div class="suc-card">
                <div class="suc-card-header">
                    <div class="suc-card-icon"><i class="fas fa-barcode"></i></div>
                    <h5>Kode Registrasi</h5>
                </div>
                <div class="suc-card-body">
                    <div class="reg-code-box">
                        <div class="reg-code-label">Kode Check-in</div>
                        <div class="reg-code-val">{{ $order->order_code }}</div>
                        <div class="reg-code-hint">Tunjukkan kode ini saat check-in pada hari event</div>
                    </div>
                </div>
            </div>

            <!-- Detail grid -->
            <div class="detail-grid">
                <!-- Event detail -->
                <div class="suc-card" style="margin-bottom:0">
                    <div class="suc-card-header">
                        <div class="suc-card-icon"><i class="fas fa-calendar-alt"></i></div>
                        <h5>Detail Event</h5>
                    </div>
                    <div class="suc-card-body">
                        <div class="field-list">
                            <div class="field-item">
                                <span class="field-label">Event</span>
                                <span class="field-val">{{ $order->event->title }}</span>
                            </div>
                            <div class="field-divider"></div>
                            <div class="field-item">
                                <span class="field-label">Tanggal</span>
                                <span class="field-val">{{ $order->event->event_date->format('d F Y') }}</span>
                            </div>
                            <div class="field-divider"></div>
                            <div class="field-item">
                                <span class="field-label">Waktu</span>
                                <span class="field-val">{{ $order->event->event_date->format('H:i') }} WIB</span>
                            </div>
                            <div class="field-divider"></div>
                            <div class="field-item">
                                <span class="field-label">Lokasi</span>
                                <span class="field-val">{{ $order->event->location }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase detail -->
                <div class="suc-card" style="margin-bottom:0">
                    <div class="suc-card-header">
                        <div class="suc-card-icon"><i class="fas fa-ticket-alt"></i></div>
                        <h5>Detail Pembelian</h5>
                    </div>
                    <div class="suc-card-body">
                        <div class="field-list">
                            <div class="field-item">
                                <span class="field-label">Tipe Tiket</span>
                                @foreach($order->orderItems as $item)
                                    <span class="field-val">{{ $item->ticketType->name }}</span>
                                @endforeach
                            </div>
                            <div class="field-divider"></div>
                            <div class="field-item">
                                <span class="field-label">Jumlah</span>
                                <span class="field-val">{{ $order->quantity }} Tiket</span>
                            </div>
                            <div class="field-divider"></div>
                            <div class="field-item">
                                <span class="field-label">Total Pembayaran</span>
                                <span class="field-val accent">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="field-divider"></div>
                            <div class="field-item">
                                <span class="field-label">Status</span>
                                <span class="field-val"><span class="status-pill">Terbayar</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info penting -->
            <div class="suc-card" style="margin-top:1.25rem">
                <div class="suc-card-header">
                    <div class="suc-card-icon"><i class="fas fa-info-circle"></i></div>
                    <h5>Informasi Penting</h5>
                </div>
                <div class="suc-card-body">
                    <div class="info-grid">
                        <div class="info-item ii-amber">
                            <div class="info-item-header">
                                <div class="ii-icon"><i class="fas fa-envelope"></i></div>
                                <h6>Konfirmasi Email</h6>
                            </div>
                            <p>Bukti registrasi telah dikirim ke:<br><strong>{{ Auth::user()->email }}</strong></p>
                        </div>
                        <div class="info-item ii-green">
                            <div class="info-item-header">
                                <div class="ii-icon"><i class="fas fa-download"></i></div>
                                <h6>Download E-Ticket</h6>
                            </div>
                            <p>Unduh tiket elektronik dan bawa saat acara dimulai.</p>
                            <a href="{{ route('user.payment.download-ticket', $order->id) }}" class="btn-dl">
                                <i class="fas fa-download"></i> Unduh Tiket
                            </a>
                        </div>
                        <div class="info-item ii-blue">
                            <div class="info-item-header">
                                <div class="ii-icon"><i class="fas fa-qrcode"></i></div>
                                <h6>Check-in</h6>
                            </div>
                            <p>Tunjukkan kode registrasi atau e-ticket saat check-in di lokasi event.</p>
                        </div>
                        <div class="info-item ii-gray">
                            <div class="info-item-header">
                                <div class="ii-icon"><i class="fas fa-headset"></i></div>
                                <h6>Perubahan Data</h6>
                            </div>
                            <p>Jika perlu mengubah data atau membatalkan, silakan hubungi tim support kami.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="action-grid">
                <a href="{{ route('user.dashboard') }}" class="btn-act-primary">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('user.events.index') }}" class="btn-act-outline">
                    <i class="fas fa-search"></i> Cari Event Lainnya
                </a>
                <a href="{{ route('user.payment.history') }}" class="btn-act-outline">
                    <i class="fas fa-history"></i> Riwayat Pembayaran
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@section('ExtraJS')
<script>
    function printReceipt() {
        window.print();
    }
</script>
@endsection