<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:    #0f1923;
            --slate:  #1e2d3d;
            --gold:   #c9a84c;
            --gold-lt:#e8c96a;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--slate);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .geo-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 52px 52px;
            pointer-events: none;
        }
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
        }
        .orb-1 { width: 500px; height: 500px; background: rgba(201,168,76,.14); top: -150px; right: -100px; }
        .orb-2 { width: 400px; height: 400px; background: rgba(66,135,245,.09); bottom: -120px; left: -80px; }

        /* ── CENTER CARD ── */
        .card {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 32px;
            animation: fadeUp .7s ease both;
        }

        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 8px 40px rgba(0,0,0,.3);
        }

        .title {
            text-align: center;
        }
        .title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #fff;
            margin-bottom: 8px;
        }
        .title h1 em {
            font-style: normal;
            color: var(--gold-lt);
        }
        .title p {
            font-size: .9rem;
            color: rgba(255,255,255,.4);
        }

        .actions {
            display: flex;
            gap: 12px;
        }

        .btn-ghost {
            padding: 12px 28px;
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.18);
            border-radius: 11px;
            color: rgba(255,255,255,.8);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            text-decoration: none;
            transition: border-color .2s, background .2s, color .2s;
        }
        .btn-ghost:hover {
            border-color: rgba(201,168,76,.45);
            background: rgba(201,168,76,.07);
            color: var(--gold-lt);
        }

        .btn-solid {
            padding: 12px 28px;
            background: var(--gold);
            border: 1.5px solid var(--gold);
            border-radius: 11px;
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .2s, box-shadow .2s, transform .15s;
        }
        .btn-solid:hover {
            background: var(--gold-lt);
            box-shadow: 0 4px 20px rgba(201,168,76,.35);
            transform: translateY(-1px);
            color: var(--ink);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="geo-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="card">
        <div class="logo">
            <!-- <img src="{{ asset('assets/img/kaiadmin/LogoLoginCopy.png') }}" alt="Logo"> -->
        </div>

        <div class="title">
            <h1>Selamat <em>Datang</em></h1>
            <p>Silakan masuk atau daftar untuk melanjutkan</p>
            <br>
            <a href="{{ route('login') }}" class="btn-ghost">Login</a>
            <a href="/register" class="btn-solid">Register</a>
        </div>        
    </div>
</body>

</html>