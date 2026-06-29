<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P4S Gubuk Sayur Lumajang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @php
        $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
    @endphp

    <style>
        :root {
            --p4s-green: {{ $themeColor }};
            --p4s-dark: #0f4c3a;
            --text-primary: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg-light: #f8fafc;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: var(--bg-light);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── NAVBAR KACA TRANSPARAN (GLASSMORPHISM) ── */
        .navbar-main {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }

        .navbar-inner {
            display: flex;
            align-items: stretch;
            height: 68px;
        }

        /* Brand / Logo */
        .navbar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 0;
            padding-right: 28px;
            border-right: 1px solid var(--border);
            flex-shrink: 0;
            text-decoration: none;
        }
        .navbar-brand-wrap img {
            height: 38px;
            width: auto;
            display: block;
        }
        .logo-sep {
            width: 1px;
            height: 28px;
            background: var(--border);
            margin: 0 16px;
        }

        /* Nav links */
        .navbar-nav-main {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0 0 0 28px;
            gap: 2px;
            flex: 1;
        }
        .nav-main-item { display: flex; align-items: stretch; }
        .nav-main-link {
            display: flex;
            align-items: center;
            padding: 0 14px;
            height: 68px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted) !important;
            text-decoration: none;
            text-transform: none;
            letter-spacing: -0.01em;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .nav-main-link:hover {
            color: var(--text-primary) !important;
            border-bottom-color: var(--border);
        }
        .nav-main-link.active {
            color: var(--p4s-dark) !important;
            font-weight: 600;
            border-bottom-color: var(--p4s-green);
        }

        /* CTA button in navbar */
        .navbar-cta {
            display: flex;
            align-items: center;
            margin-left: auto;
            padding-left: 20px;
            border-left: 1px solid var(--border);
            flex-shrink: 0;
        }
        .btn-nav-cta {
            background: var(--p4s-green);
            color: #fff !important;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 9px 20px;
            border-radius: 6px;
            text-decoration: none;
            letter-spacing: -0.01em;
            transition: all 0.2s;
            white-space: nowrap;
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
        }
        .btn-nav-cta:hover {
            background: var(--p4s-dark);
            color: #fff !important;
            transform: translateY(-2px);
        }

        /* Mobile toggler */
        .navbar-toggler-main {
            border: none;
            background: none;
            padding: 8px;
            cursor: pointer;
            display: none;
            flex-direction: column;
            gap: 5px;
            margin-left: auto;
        }
        .toggler-bar {
            width: 22px; height: 2px;
            background: var(--text-primary);
            border-radius: 2px;
            transition: all 0.25s;
            display: block;
        }

        /* Mobile nav */
        .navbar-mobile {
            display: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--border);
            padding: 12px 0;
        }
        .navbar-mobile.open { display: block; }
        .nav-mobile-link {
            display: block;
            padding: 11px 24px;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            text-transform: none;
            transition: all 0.15s;
        }
        .nav-mobile-link:hover,
        .nav-mobile-link.active {
            color: var(--p4s-dark);
            background: rgba(0,0,0,0.03);
            padding-left: 30px;
        }
        .nav-mobile-link.active { font-weight: 600; }

        @media (max-width: 991px) {
            .navbar-nav-main,
            .navbar-cta { display: none; }
            .navbar-toggler-main { display: flex; }
        }

        /* ── FOOTER ──────────────────────────────────── */
        .footer-main {
            background: #fff;
            border-top: 1px solid var(--border);
        }
        .footer-top {
            padding: 48px 0 36px;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 14px;
        }
        .footer-brand img { height: 32px; width: auto; }
        .footer-brand .logo-sep { margin: 0 12px; }
        .footer-tagline {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 260px;
            text-transform: none;
        }
        .footer-col-title {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-primary);
            margin-bottom: 14px;
        }
        .footer-link {
            display: block;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-decoration: none;
            text-transform: none;
            margin-bottom: 9px;
            transition: color 0.15s;
        }
        .footer-link:hover { color: var(--p4s-green); }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }
        .footer-contact-icon {
            width: 28px; height: 28px;
            border-radius: 6px;
            background: #f0fdf4;
            color: var(--p4s-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .footer-contact-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
            text-transform: none;
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding: 16px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .footer-copy {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .footer-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .footer-social {
            display: flex;
            gap: 8px;
        }
        .social-btn {
            width: 30px; height: 30px;
            border-radius: 6px;
            border: 1px solid var(--border);
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .social-btn:hover {
            border-color: var(--p4s-green);
            color: var(--p4s-green);
            background: #f0fdf4;
        }

        /* Tombol Admin */
        .footer-admin-btn {
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .footer-admin-btn:hover {
            color: var(--p4s-green);
            border-color: var(--p4s-green);
            background: #f0fdf4;
        }
        .footer-admin-sep {
            width: 1px;
            height: 16px;
            background: var(--border);
        }

        /* ── GLOBAL UTILS ────────────────────────────── */
        .btn-otsuka {
            background: var(--p4s-green);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 9px 20px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            letter-spacing: -0.01em;
            transition: all 0.2s;
            display: inline-block;
        }
        .btn-otsuka:hover {
            background: var(--p4s-dark);
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<nav class="navbar-main">
    <div class="container">
        <div class="navbar-inner">

            <a href="{{ url('/') }}" class="navbar-brand-wrap">
                <img src="{{ asset('assets/img/logo-lembaga.png') }}" alt="Logo Lembaga" onerror="this.src='{{ asset('assets/img/logo-lembaga.png') }}'">
                <div class="logo-sep"></div>
                <img src="{{ asset('assets/img/logo-gubuk.png') }}" alt="Logo Gubuk Sayur" onerror="this.src='{{ asset('assets/img/logo-gubuk.png') }}'">
            </a>

            <ul class="navbar-nav-main">
                <li class="nav-main-item">
                    <a href="{{ url('/') }}" class="nav-main-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                </li>
                <li class="nav-main-item">
                    <a href="{{ url('/pelatihan') }}" class="nav-main-link {{ request()->is('pelatihan*') ? 'active' : '' }}">Pelatihan</a>
                </li>
                <li class="nav-main-item">
                    <a href="{{ url('/kunjungan') }}" class="nav-main-link {{ request()->is('kunjungan*') ? 'active' : '' }}">Kunjungan</a>
                </li>
                <li class="nav-main-item">
                    <a href="{{ url('/kemitraan') }}" class="nav-main-link {{ request()->is('kemitraan*') ? 'active' : '' }}">Kemitraan</a>
                </li>
                <li class="nav-main-item">
                    <a href="{{ url('/hubungi-kami') }}" class="nav-main-link {{ request()->is('hubungi-kami*') ? 'active' : '' }}">Hubungi Kami</a>
                </li>
            </ul>

            <div class="navbar-cta">
                <a href="{{ url('/kunjungan') }}" class="btn-nav-cta">Reservasi Kunjungan</a>
            </div>

            <button class="navbar-toggler-main" id="mobileToggler" aria-label="Menu">
                <span class="toggler-bar"></span>
                <span class="toggler-bar"></span>
                <span class="toggler-bar"></span>
            </button>

        </div>
    </div>

    <div class="navbar-mobile" id="mobileNav">
        <div class="container">
            <a href="{{ url('/') }}" class="nav-mobile-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="{{ url('/pelatihan') }}" class="nav-mobile-link {{ request()->is('pelatihan*') ? 'active' : '' }}">Pelatihan</a>
            <a href="{{ url('/kunjungan') }}" class="nav-mobile-link {{ request()->is('kunjungan*') ? 'active' : '' }}">Kunjungan</a>
            <a href="{{ url('/kemitraan') }}" class="nav-mobile-link {{ request()->is('kemitraan*') ? 'active' : '' }}">Kemitraan</a>
            <a href="{{ url('/hubungi-kami') }}" class="nav-mobile-link {{ request()->is('hubungi-kami*') ? 'active' : '' }}">Hubungi Kami</a>
            <div style="padding: 12px 24px 4px;">
                <a href="{{ url('/kunjungan') }}" class="btn-otsuka w-100 text-center d-block">Reservasi Kunjungan</a>
            </div>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="footer-main">
    <div class="container">
        <div class="footer-top">
            <div class="row g-5">

                <div class="col-lg-4">
                    <div class="footer-brand">
                        <img src="{{ asset('assets/img/logo-lembaga.png') }}" alt="Logo Lembaga" onerror="this.src='{{ asset('assets/img/logo-lembaga.png') }}'">
                        <div class="logo-sep"></div>
                        <img src="{{ asset('assets/img/logo-gubuk.png') }}" alt="Logo Gubuk Sayur" onerror="this.src='{{ asset('assets/img/logo-gubuk.png') }}'">
                    </div>
                    <p class="footer-tagline">
                        Pertanian modern berbasis hidroponik di Lumajang, Jawa Timur.
                    </p>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="footer-col-title">Navigasi</div>
                    <a href="{{ url('/') }}" class="footer-link">Beranda</a>
                    <a href="{{ url('/pelatihan') }}" class="footer-link">Pelatihan</a>
                    <a href="{{ url('/kunjungan') }}" class="footer-link">Kunjungan</a>
                    <a href="{{ url('/kemitraan') }}" class="footer-link">Kemitraan</a>
                    <a href="{{ url('/hubungi-kami') }}" class="footer-link">Hubungi Kami</a>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="footer-col-title">Program</div>
                    <a href="{{ url('/pelatihan') }}" class="footer-link">Pelatihan</a>
                    <a href="{{ url('/kunjungan') }}" class="footer-link">Kunjungan edukasi</a>
                    <a href="{{ url('/kemitraan') }}" class="footer-link">Kemitraan</a>
                </div>

                <div class="col-lg-4">
                    <div class="footer-col-title">Kontak</div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="footer-contact-text">Lumajang, Jawa Timur, Indonesia</div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fab fa-whatsapp"></i></div>
                        <div class="footer-contact-text">+62 812-1721-4839</div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
                        <div class="footer-contact-text">gubuksayur1@gmail.com</div>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copy">
                © 2026 P4S Gubuk Sayur Lumajang. Seluruh hak cipta dilindungi.
            </div>
            <div class="footer-right">
                <a href="{{ url('/login') }}" class="footer-admin-btn">
                    <i class="fas fa-lock" style="font-size: 0.65rem;"></i>
                    Masuk sebagai Admin
                </a>
                <div class="footer-admin-sep"></div>
                <div class="footer-social">
                    <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/6281217214839" class="social-btn" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggler = document.getElementById('mobileToggler');
    const mobileNav = document.getElementById('mobileNav');
    if (toggler && mobileNav) {
        toggler.addEventListener('click', function () {
            mobileNav.classList.toggle('open');
        });
    }
</script>
</body>
</html>