<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P4S Gubuk Sayur - Profesional & Modern</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @php
        $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
    @endphp

    <style>
        :root { --p4s-green: {{ $themeColor }}; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #333; overflow-x: hidden; }

        /* NAVBAR OTSUKA STYLE */
        .navbar-otsuka {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 4px solid var(--p4s-green);
            padding: 1.2rem 0;
        }
        .navbar-brand { font-weight: 800; color: var(--p4s-green) !important; letter-spacing: -1px; font-size: 1.5rem; text-decoration: none; text-transform: lowercase; }
        .nav-link { 
            font-weight: 700; color: #1a1a1a !important; text-transform: lowercase; 
            margin: 0 15px; font-size: 0.95rem; transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: var(--p4s-green) !important; }

        /* BUTTON OTSUKA GREEN */
        .btn-otsuka {
            background-color: var(--p4s-green);
            color: white !important; border-radius: 50px; padding: 12px 35px;
            font-weight: 700; border: none; transition: 0.3s ease; text-transform: lowercase;
            text-decoration: none; display: inline-block;
        }
        .btn-otsuka:hover { background-color: #146c43; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .footer-otsuka { background: #fff; border-top: 1px solid #eee; padding: 50px 0; margin-top: 0;}
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-otsuka sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">p4s gubuk sayur.</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('pelatihan*') ? 'active' : '' }}" href="{{ url('/pelatihan') }}">pelatihan</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('kunjungan*') ? 'active' : '' }}" href="{{ url('/kunjungan') }}">kunjungan</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('kemitraan*') ? 'active' : '' }}" href="{{ url('/kemitraan') }}">kemitraan</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('hubungi-kami*') ? 'active' : '' }}" href="{{ url('/hubungi-kami') }}">hubungi kami</a></li>
                </ul>
            </div>
            <div class="d-none d-lg-block">
               
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-otsuka text-center">
        <div class="container">
            <h5 class="fw-bold mb-3" style="color: var(--p4s-green); text-transform: lowercase;">p4s gubuk sayur lumajang.</h5>
            <p class="text-muted small mb-0">© 2026 inovasi pertanian berkelanjutan. seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>