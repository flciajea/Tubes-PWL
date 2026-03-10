<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --ink: #0f1923;
            --slate: #1e2d3d;
            --gold: #c9a84c;
            --gold-lt: #e8c96a;
            --cream: #f7f3ec;
            --mist: #eef1f5;
            --red: #d94f4f;
            --green: #2ecc71;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--mist);
            display: flex;
            align-items: stretch;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            flex: 0 0 46%;
            background: var(--slate);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 52px;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 80% 110%, rgba(201, 168, 76, .18) 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 10% -10%, rgba(201, 168, 76, .10) 0%, transparent 60%);
        }

        .geo-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .04) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .25;
        }

        .orb-1 {
            width: 320px;
            height: 320px;
            background: var(--gold);
            bottom: -60px;
            left: -60px;
        }

        .orb-2 {
            width: 200px;
            height: 200px;
            background: #4287f5;
            top: 40px;
            right: -40px;
        }

        .panel-left .badge-tag {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201, 168, 76, .15);
            border: 1px solid rgba(201, 168, 76, .35);
            color: var(--gold-lt);
            font-size: .72rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 28px;
            width: fit-content;
            animation: fadeUp .8s ease both;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            background: var(--gold-lt);
            border-radius: 50%;
            animation: pulse 2s ease infinite;
        }

        .panel-left h1 {
            position: relative;
            z-index: 2;
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 2.9rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.18;
            margin-bottom: 18px;
            animation: fadeUp .8s .12s ease both;
        }

        .panel-left h1 em {
            font-style: normal;
            color: var(--gold-lt);
        }

        .panel-left p {
            position: relative;
            z-index: 2;
            color: rgba(255, 255, 255, .55);
            font-size: .93rem;
            line-height: 1.7;
            max-width: 340px;
            margin-bottom: 36px;
            animation: fadeUp .8s .22s ease both;
        }

        /* Steps indicator */
        .steps {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 16px;
            animation: fadeUp .8s .32s ease both;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(201, 168, 76, .18);
            border: 1.5px solid rgba(201, 168, 76, .4);
            color: var(--gold-lt);
            font-size: .78rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            color: rgba(255, 255, 255, .6);
            font-size: .85rem;
        }

        .step-text strong {
            color: rgba(255, 255, 255, .88);
            font-weight: 500;
            display: block;
            font-size: .88rem;
        }

        .deco-line {
            position: absolute;
            z-index: 2;
            top: 0;
            right: 52px;
            width: 1px;
            height: 100px;
            background: linear-gradient(to bottom, transparent, var(--gold));
            animation: growDown .9s .4s ease both;
        }

        /* ── RIGHT PANEL ── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            background: var(--mist);
            position: relative;
            overflow-y: auto;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(201, 168, 76, .07) 0%, transparent 70%);
            pointer-events: none;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
            padding: 20px 0;
            animation: fadeUp .7s .1s ease both;
        }

        .register-card .logo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 28px;
        }

        .register-card .logo-wrap img {
            width: 110px;
            height: auto;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .10);
        }

        .register-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .register-card .sub {
            color: #8a96a3;
            font-size: .875rem;
            margin-bottom: 28px;
        }

        .register-card .sub a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }

        .register-card .sub a:hover {
            text-decoration: underline;
        }

        /* ── FORM ROW ── */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ── FIELDS ── */
        .field-group {
            margin-bottom: 16px;
            position: relative;
        }

        .field-group label {
            display: block;
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #7a8694;
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aab4be;
            pointer-events: none;
            transition: color .2s;
        }

        .field-group:focus-within .input-icon {
            color: var(--gold);
        }

        .field-group input,
        .field-group select {
            width: 100%;
            background: #fff;
            border: 1.5px solid #dde3ec;
            border-radius: 11px;
            padding: 12px 15px 12px 43px;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--ink);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
            appearance: none;
        }

        .field-group input:focus,
        .field-group select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, .12);
        }

        .field-group input::placeholder {
            color: #bcc5ce;
        }

        /* password strength */
        .pw-strength {
            display: flex;
            gap: 5px;
            margin-top: 8px;
        }

        .pw-bar {
            flex: 1;
            height: 3px;
            background: #e2e8f0;
            border-radius: 10px;
            transition: background .3s;
        }

        .pw-label {
            font-size: .72rem;
            color: #aab4be;
            margin-top: 5px;
            min-height: 16px;
            transition: color .3s;
        }

        .toggle-pw {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #aab4be;
            cursor: pointer;
            padding: 4px;
            transition: color .2s;
        }

        .toggle-pw:hover {
            color: var(--gold);
        }

        /* ── SUBMIT ── */
        .btn-register {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: var(--slate);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            font-weight: 500;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background .25s, transform .15s, box-shadow .25s;
            margin-top: 6px;
        }

        .btn-register::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(201, 168, 76, .18), transparent 60%);
            opacity: 0;
            transition: opacity .3s;
        }

        .btn-register:hover {
            background: var(--ink);
            box-shadow: 0 8px 24px rgba(15, 25, 35, .22);
            transform: translateY(-1px);
        }

        .btn-register:hover::after {
            opacity: 1;
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            background: rgba(255, 255, 255, .12);
            border-radius: 50%;
            transition: transform .25s;
        }

        .btn-register:hover .btn-arrow {
            transform: translateX(3px);
        }

        /* login link */
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: .85rem;
            color: #8a96a3;
        }

        .login-link a {
            color: var(--gold);
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* ── ERRORS ── */
        .alert-errors {
            background: #fff2f2;
            border: 1px solid #fcd5d5;
            border-left: 4px solid var(--red);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            animation: shake .4s ease;
        }

        .alert-errors p {
            font-size: .85rem;
            color: var(--red);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-errors ul {
            margin: 6px 0 0 24px;
            padding: 0;
        }

        .alert-errors li {
            font-size: .83rem;
            color: #c0392b;
            margin-bottom: 3px;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes growDown {
            from {
                transform: scaleY(0);
                transform-origin: top;
            }

            to {
                transform: scaleY(1);
                transform-origin: top;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
                overflow: auto;
            }

            .panel-left {
                flex: 0 0 auto;
                padding: 36px 28px;
                min-height: auto;
            }

            .steps {
                display: none;
            }

            .deco-line {
                display: none;
            }

            .panel-right {
                padding: 36px 20px;
                overflow-y: visible;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>

    <!-- LEFT PANEL -->
    <div class="panel-left">
        <div class="geo-grid"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="deco-line"></div>

        <div class="badge-tag">
            <span class="badge-dot"></span>
            Pendaftaran Akun
        </div>

        <h1>Mulai<br>Perjalanan <em>Anda.</em></h1>
        <p>Daftarkan akun baru Anda dan nikmati akses penuh ke semua fitur sistem.</p>

        <div class="steps">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">
                    <strong>Isi Data Diri</strong>
                    Nama lengkap dan informasi kontak
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">
                    <strong>Buat Kata Sandi</strong>
                    Amankan akun dengan password kuat
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">
                    <strong>Akses Dashboard</strong>
                    Mulai kelola semua aktivitas Anda
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="panel-right">
        <div class="register-card">
            <h2>Buat Akun Baru</h2>
            <p class="sub">Sudah punya akun? <a href="/login">Masuk di sini</a></p>

            @if ($errors->any())
                <div class="alert-errors">
                    <p>
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        Terjadi kesalahan:
                    </p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST" autocomplete="off">
                @csrf

                <!-- Full Name -->
                <div class="field-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="16" height="16" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>

                        <input type="text" name="name" id="name" placeholder="Nama lengkap"
                            value="{{ old('name') }}" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="field-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="16" height="16" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <input type="email" name="email" id="email" placeholder="nama@email.com"
                            value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Phone -->
                <div class="field-group">
                    <label for="phone">No. Telepon</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="16" height="16" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <input type="tel" name="phone" id="phone" placeholder="08xxxxxxxxxx"
                            value="{{ old('phone') }}">
                    </div>
                </div>

                <!-- Password -->
                <div class="field-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="16" height="16" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                        <input type="password" name="password" id="password" placeholder="Min. 8 karakter" required
                            oninput="checkStrength(this.value)">
                        <button type="button" class="toggle-pw" onclick="togglePw('password','eye-1')"
                            aria-label="Tampilkan password">
                            <svg id="eye-1" width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <div class="pw-strength">
                        <div class="pw-bar" id="bar1"></div>
                        <div class="pw-bar" id="bar2"></div>
                        <div class="pw-bar" id="bar3"></div>
                        <div class="pw-bar" id="bar4"></div>
                    </div>
                    <div class="pw-label" id="pw-label"></div>
                </div>

                <!-- Confirm Password -->
                <div class="field-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="16" height="16" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Ulangi password" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eye-2')"
                            aria-label="Tampilkan konfirmasi password">
                            <svg id="eye-2" width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <span>Daftar Sekarang</span>
                    <span class="btn-arrow">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="/login">Masuk sekarang</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePw(fieldId, iconId) {
            const pw = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            const isHidden = pw.type === 'password';
            pw.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ?
                `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>` :
                `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }

        function checkStrength(val) {
            const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'),
                document.getElementById('bar4')
            ];
            const label = document.getElementById('pw-label');
            const colors = {
                0: '#e2e8f0',
                1: '#e74c3c',
                2: '#e67e22',
                3: '#f1c40f',
                4: '#2ecc71'
            };
            const labels = {
                0: '',
                1: 'Terlalu lemah',
                2: 'Cukup',
                3: 'Kuat',
                4: 'Sangat kuat'
            };

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const color = val.length === 0 ? colors[0] : colors[score];

            bars.forEach((bar, i) => {
                bar.style.background = (val.length > 0 && i < score) ? color : '#e2e8f0';
            });

            label.textContent = val.length === 0 ? '' : labels[score];
            label.style.color = color;
        }
    </script>
</body>

</html>
