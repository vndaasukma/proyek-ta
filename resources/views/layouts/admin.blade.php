<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin P4S - Gubuk Sayur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .sidebar {
            width: 250px; height: 100vh; position: fixed;
            background: #111827; color: white; padding-top: 20px;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        .sidebar-brand { padding: 10px 20px; margin-bottom: 20px; }
        .sidebar a {
            color: #9ca3af; text-decoration: none; display: block;
            padding: 12px 20px; border-radius: 8px; margin: 4px 10px; transition: 0.3s;
        }
        .sidebar a:hover { background: #1f2933; color: white; }
        .sidebar a.active { background: #198754; color: white; box-shadow: 0 4px 15px rgba(25,135,84,0.3); }
        
        .content { margin-left: 260px; padding: 25px; min-height: 100vh; }
        
        .navbar-custom {
            background: white; padding: 15px 25px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .badge-notif { font-size: 0.7rem; padding: 0.35em 0.65em; }
    </style>
</head>
<body>

    <!-- ── SIDEBAR MENU NAVIGATION ── -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h5 class="fw-bold text-success mb-0">🌱 Admin P4S</h5>
            <small class="text-muted">Gubuk Sayur Dashboard</small>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line me-2"></i> Dashboard
        </a>

        <a href="{{ route('kelas-pelatihan.index') }}" class="{{ request()->is('admin/kelas-pelatihan*') ? 'active' : '' }}">
            <i class="fas fa-graduation-cap me-2"></i> Kelas Pelatihan
        </a>

        <a href="{{ route('pendaftaran-pelatihan.index') }}" class="{{ request()->is('admin/pendaftaran-pelatihan*') ? 'active' : '' }}">
            <i class="fas fa-user-edit me-2"></i> Pendaftaran
        </a>

        <a href="{{ route('admin.kunjungan.pendaftaran') }}" class="{{ request()->is('admin/pendaftaran-kunjungan*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-2"></i> Kunjungan
        </a>

        <a href="{{ route('admin.kemitraan.index') }}" class="{{ request()->is('admin/kemitraan*') ? 'active' : '' }}">
            <i class="fas fa-handshake me-2"></i> Manajemen Kemitraan
        </a>

        <a href="{{ route('admin.pesan.index') }}" class="{{ request()->is('admin/pesan*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
            <span><i class="fas fa-envelope-open-text me-2"></i> Pesan Masuk</span>
            @php $notif = \App\Models\KontakPesan::count(); @endphp
            @if($notif > 0)
                <span class="badge bg-danger rounded-pill badge-notif">{{ $notif }}</span>
            @endif
        </a>

        <!-- MENU FASILITAS -->
        <a href="{{ route('admin.fasilitas.index') }}" class="{{ request()->is('admin/fasilitas*') ? 'active' : '' }}">
            <i class="fas fa-building me-2"></i> <span class="text-lowercase">Fasilitas</span>
        </a>

        <a href="{{ route('admin.product.index') }}" class="{{ request()->is('admin/product*') ? 'active' : '' }}">
            <i class="fas fa-box me-2"></i> <span class="text-lowercase">produk kami</span>
        </a>

        <a href="{{ route('admin.galeri.index') }}" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">
            <i class="fas fa-images me-2"></i> <span class="text-lowercase">galeri foto</span>
        </a>

        <a href="{{ route('admin.reviews.index') }}" class="{{ request()->is('admin/reviews*') ? 'active' : '' }}">
            <i class="fas fa-star me-2"></i> <span class="text-lowercase">moderasi review</span>
        </a>

        <hr class="mx-3 opacity-25">
        
        <a href="/" target="_blank">
            <i class="fas fa-external-link-alt me-2"></i> Lihat Website
        </a>
    </div>

    <!-- ── MAIN CONTENT AREA ── -->
    <div class="content">
        <!-- TOPBAR NAVBAR -->
        <div class="navbar-custom d-flex justify-content-between align-items-center">
            <div class="fw-bold text-secondary text-capitalize">
                @if(request()->is('admin/dashboard')) dashboard 
                @elseif(request()->is('admin/pendaftaran-kunjungan*')) manajemen kunjungan 
                @elseif(request()->is('admin/kemitraan*')) manajemen kemitraan
                @elseif(request()->is('admin/pesan*')) pesan masuk
                @elseif(request()->is('admin/galeri*')) manajemen galeri
                @elseif(request()->is('admin/product*')) manajemen produk
                @elseif(request()->is('admin/reviews*')) manajemen review
                @elseif(request()->is('admin/fasilitas*')) manajemen fasilitas
                @else admin panel 
                @endif
            </div>
            
            <div class="dropdown">
                <a class="dropdown-toggle text-dark text-decoration-none fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name ?? 'Admin Vinda' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        @yield('content')
    </div>

<!-- BOOTSTRAP CORE JAVASCRIPT BUNDLE -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 🔒 ENGINE POLLING REALTIME UNIVERSAL ANTI-KEDIP & EVENT BYPASS ENGINE -->
<script>
    window.modalLock = false;

    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-bs-toggle="modal"]') || e.target.closest('.btn-success') || e.target.closest('.btn-outline-primary')) {
            window.modalLock = true;
            setTimeout(() => { window.modalLock = false; }, 12000);
        }
    });

    setInterval(function() {
        if (window.modalLock === true) return;

        const targetFokus = document.activeElement;
        if (targetFokus && ['INPUT', 'TEXTAREA', 'SELECT'].includes(targetFokus.tagName)) {
            return; 
        }

        if (document.querySelector('.modal.show') || document.querySelector('.modal-backdrop') || document.body.classList.contains('modal-open')) {
            return;
        }

        if (document.querySelector('.dropdown-menu.show')) {
            return;
        }

        const cacheBusterUrl = window.location.pathname + window.location.search + 
            (window.location.search ? '&' : '?') + 'vinda_sync=' + Date.now();

        fetch(cacheBusterUrl, { cache: 'no-store' })
            .then(response => {
                if (!response.ok) throw new Error('Koneksi background sync tertunda.');
                return response.text();
            })
            .then(html => {
                if (window.modalLock === true) return;
                if (document.querySelector('.modal.show') || document.querySelector('.modal-backdrop') || document.body.classList.contains('modal-open')) {
                    return;
                }
                if (document.querySelector('.dropdown-menu.show')) {
                    return;
                }

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // 1. Sinkronkan komponen Sidebar
                const newSidebar = doc.querySelector('.sidebar');
                const oldSidebar = document.querySelector('.sidebar');
                if (oldSidebar && newSidebar) {
                    if (oldSidebar.innerHTML.trim() !== newSidebar.innerHTML.trim()) {
                        const currentScroll = oldSidebar.scrollTop; 
                        oldSidebar.innerHTML = newSidebar.innerHTML;
                        oldSidebar.scrollTop = currentScroll;
                    }
                }
                
                // 2. Sinkronkan komponen Content
                const newContent = doc.querySelector('.content');
                const oldContent = document.querySelector('.content');
                if (oldContent && newContent) {
                    
                    if (oldContent.innerHTML.trim() === newContent.innerHTML.trim()) {
                        return;
                    }

                    // Ganti isi HTML konten utama
                    oldContent.innerHTML = newContent.innerHTML;

                    // Beri jeda 80ms agar element canvas terpasang sempurna di layar sebelum digambar
                    setTimeout(() => {
                        // Bersihkan sisa-sisa instansi chart lama dari memori RAM
                        if (window.Chart && Chart.instances) {
                            Object.keys(Chart.instances).forEach(id => {
                                Chart.instances[id].destroy();
                            });
                        }

                        oldContent.querySelectorAll('script').forEach(scriptTag => {
                            if (!scriptTag.src && scriptTag.innerHTML.trim().length > 0) {
                                try {
                                    // 🚀 SINKRONISASI COKRA UTAMA: Amankan fungsi asli addEventListener browser
                                    const originalAddEventListener = document.addEventListener;

                                    const runIsolatedEnv = function() {
                                        // Paksa event DOMContentLoaded langsung dieksekusi detik ini juga!
                                        document.addEventListener = function(event, callback) {
                                            if (event === 'DOMContentLoaded' || event === 'load') {
                                                callback();
                                            } else {
                                                originalAddEventListener.apply(document, arguments);
                                            }
                                        };

                                        // Paksa event jQuery Ready langsung dieksekusi jika dashboard memakai jQuery
                                        const origJQuery = window.$ || window.jQuery;
                                        let $ = origJQuery;
                                        let jQuery = origJQuery;
                                        if (origJQuery) {
                                            $ = jQuery = function(selector) {
                                                if (typeof selector === 'function') {
                                                    selector();
                                                    return origJQuery(document);
                                                }
                                                return origJQuery(selector);
                                            };
                                            Object.assign($, origJQuery);
                                            $.ready = function(cb) { cb(); };
                                        }

                                        // Jalankan skrip Chart kamu secara terisolasi tanpa error redeclare variabel
                                        window.eval(scriptTag.innerHTML);
                                    };

                                    runIsolatedEnv();
                                    
                                    // Kembalikan addEventListener ke fungsi bawaan browser
                                    document.addEventListener = originalAddEventListener;

                                ]} catch (e) {
                                    console.warn('Penyelarasan diagram otomatis ditunda:', e);
                                }
                            }
                        });
                    }, 80);
                }
            })
            .catch(error => console.warn('Realtime background log:', error));

    }, 5000);
</script>

</body>
</html>