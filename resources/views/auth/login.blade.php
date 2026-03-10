<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:    #0f1923;
            --slate:  #1e2d3d;
            --gold:   #c9a84c;
            --gold-lt:#e8c96a;
            --cream:  #f7f3ec;
            --mist:   #eef1f5;
            --red:    #d94f4f;
        }

        html, body { height: 100%; }

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
            justify-content: flex-end;
            padding: 56px 52px;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 110%, rgba(201,168,76,.18) 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 90% -10%, rgba(201,168,76,.10) 0%, transparent 60%);
        }

        .geo-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .25;
        }
        .orb-1 { width: 340px; height: 340px; background: var(--gold); top: -80px; right: -80px; }
        .orb-2 { width: 240px; height: 240px; background: #4287f5; bottom: 60px; left: -60px; }

        .panel-left .badge-tag {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201,168,76,.15);
            border: 1px solid rgba(201,168,76,.35);
            color: var(--gold-lt);
            font-size: .72rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 24px;
            width: fit-content;
            animation: fadeUp .8s ease both;
        }
        .badge-dot {
            width: 6px; height: 6px;
            background: var(--gold-lt);
            border-radius: 50%;
            animation: pulse 2s ease infinite;
        }

        .panel-left h1 {
            position: relative;
            z-index: 2;
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
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
            color: rgba(255,255,255,.55);
            font-size: .93rem;
            line-height: 1.7;
            max-width: 340px;
            animation: fadeUp .8s .22s ease both;
        }

        .deco-line {
            position: absolute;
            z-index: 2;
            bottom: 0; left: 52px;
            width: 1px; height: 120px;
            background: linear-gradient(to bottom, var(--gold), transparent);
            animation: growDown .9s .4s ease both;
        }

        /* ── RIGHT PANEL ── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
            background: var(--mist);
            position: relative;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(201,168,76,.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            animation: fadeUp .7s .1s ease both;
        }

        .login-card .logo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 36px;
        }
        .login-card .logo-wrap img {
            width: 130px;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,.10);
        }

        .login-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }
        .login-card .sub {
            color: #8a96a3;
            font-size: .875rem;
            margin-bottom: 36px;
        }

        /* ── FORM ── */
        .field-group { margin-bottom: 20px; position: relative; }

        .field-group label {
            display: block;
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #7a8694;
            margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: #aab4be;
            pointer-events: none;
            transition: color .2s;
        }

        .field-group:focus-within .input-icon { color: var(--gold); }

        .field-group input {
            width: 100%;
            background: #fff;
            border: 1.5px solid #dde3ec;
            border-radius: 12px;
            padding: 13px 16px 13px 44px;
            font-family: 'DM Sans', sans-serif;
            font-size: .93rem;
            color: var(--ink);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }

        .field-group input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(201,168,76,.12);
        }
        .field-group input::placeholder { color: #bcc5ce; }

        .toggle-pw {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #aab4be; cursor: pointer;
            padding: 4px;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--gold); }

        /* ── SUBMIT ── */
        .btn-login {
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
            margin-top: 8px;
        }
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(201,168,76,.18), transparent 60%);
            opacity: 0;
            transition: opacity .3s;
        }
        .btn-login:hover {
            background: var(--ink);
            box-shadow: 0 8px 24px rgba(15,25,35,.22);
            transform: translateY(-1px);
        }
        .btn-login:hover::after { opacity: 1; }
        .btn-login:active { transform: translateY(0); }

        .btn-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px; height: 26px;
            background: rgba(255,255,255,.12);
            border-radius: 50%;
            transition: transform .25s;
        }
        .btn-login:hover .btn-arrow { transform: translateX(3px); }

        /* ── DIVIDER & LINKS ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0 18px;
            color: #bcc5ce;
            font-size: .8rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: #dde3ec;
        }

        /* ── ERRORS ── */
        .alert-errors {
            background: #fff2f2;
            border: 1px solid #fcd5d5;
            border-left: 4px solid var(--red);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 24px;
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
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes growDown {
            from { transform: scaleY(0); transform-origin: top; }
            to   { transform: scaleY(1); transform-origin: top; }
        }
        @keyframes pulse {
            0%,100% { opacity: 1; } 50% { opacity: .4; }
        }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%,60% { transform: translateX(-5px); }
            40%,80% { transform: translateX(5px); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .panel-left {
                flex: 0 0 auto;
                padding: 40px 32px;
                min-height: 220px;
                justify-content: center;
            }
            .deco-line { display: none; }
            .panel-right { padding: 40px 24px; }
        }
    </style>
</head>

<body>

    <!-- LEFT PANEL -->
    <div class="panel-left">
        <div class="geo-grid"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>

        <div class="badge-tag">
            <span class="badge-dot"></span>
            Sistem Manajemen
        </div>

        <h1>Selamat<br>Datang <em>Kembali.</em></h1>
        <p>Masuk ke dashboard Anda dan kelola semua aktivitas dengan mudah dan efisien.</p>

        <div class="deco-line"></div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="panel-right">
        <div class="login-card">
            <h2>Masuk ke Akun</h2>
            <p class="sub">Isi kredensial Anda untuk melanjutkan</p>

            @if ($errors->any())
            <div class="alert-errors">
                <p>
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Terjadi kesalahan:
                </p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/login" method="POST" autocomplete="off">
                @csrf

                <div class="field-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="text" name="email" id="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Tampilkan password">
                            <svg id="eye-icon" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <span>Masuk Sekarang</span>
                    <span class="btn-arrow">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePw() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            const isHidden = pw.type === 'password';
            pw.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    </script>
</body>

</html>