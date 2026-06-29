<!DOCTYPE html>
<!-- @author Vinda Ambitha Sukma -->
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin P4S Gubuk Sayur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .sidebar {
            width: 250px; height: 100vh; position: fixed;
            background: #111827; color: white; padding-top: 20px;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar a {
            color: #9ca3af; text-decoration: none; display: flex; align-items: center;
            padding: 12px 20px; border-radius: 8px; margin: 4px 10px; transition: 0.2s ease-in-out;
            font-size: 0.95rem;
        }
        
        .sidebar a i.menu-icon { width: 25px; text-align: center; margin-right: 10px; }
        .sidebar a:hover { background: #1f2933; color: white; }
        .sidebar a.active { background: #198754; color: white; font-weight: 500; }
        
        .submenu { margin-left: 10px; border-left: 2px solid #2d3748; padding-left: 5px; }
        .submenu a { padding: 8px 15px; font-size: 0.85rem; margin: 2px 5px; }
        .submenu a.active { background: transparent; color: #10b981; font-weight: bold; }
        .submenu a.active::before { content: '•'; margin-right: 5px; color: #10b981; }

        .nav-link[aria-expanded="true"] .fa-chevron-down { transform: rotate(180deg); transition: transform 0.3s; }
        .nav-link[aria-expanded="false"] .fa-chevron-down { transition: transform 0.3s; }

        .content { margin-left: 250px; padding: 25px; min-height: 100vh; }
        .navbar-custom {
            background: white; padding: 12px 25px; border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; z-index: 1050; }
            .sidebar.show { transform: translateX(0); }
            .content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand text-center">
        <h5 class="fw-bold mb-0 text-white"><i class="fas fa-seedling text-success me-2"></i>Admin P4S</h5>
        <small class="text-muted" style="font-size: 0.75rem;">Gubuk Sayur Dashboard</small>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-pie menu-icon"></i> <span>Dashboard</span>
    </a>

    <!-- Pengecekan Expand Otomatis Ditambahkan Route Sertifikat Pelatihan -->
    <a href="#pelatihanMenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/kelas-pelatihan*') || request()->is('admin/jadwal-pelatihan*') || request()->is('admin/pendaftaran-pelatihan*') || request()->is('admin/pelatih*') || request()->is('admin/sertifikat-pelatihan*') ? 'true' : 'false' }}" class="nav-link justify-content-between {{ request()->is('admin/kelas-pelatihan*') || request()->is('admin/jadwal-pelatihan*') || request()->is('admin/pendaftaran-pelatihan*') || request()->is('admin/pelatih*') || request()->is('admin/sertifikat-pelatihan*') ? 'text-white' : '' }}">
        <div><i class="fas fa-user-graduate menu-icon"></i> <span>Manajemen Pelatihan</span></div>
        <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
    </a>
    <div class="collapse {{ request()->is('admin/kelas-pelatihan*') || request()->is('admin/jadwal-pelatihan*') || request()->is('admin/pendaftaran-pelatihan*') || request()->is('admin/pelatih*') || request()->is('admin/sertifikat-pelatihan*') ? 'show' : '' }}" id="pelatihanMenu">
        <div class="submenu">
            <a href="{{ route('kelas-pelatihan.index') }}" class="{{ request()->routeIs('kelas-pelatihan.*') ? 'active' : '' }}">Data Kelas Pelatihan</a>
            <a href="{{ route('jadwal-pelatihan.index') }}" class="{{ request()->routeIs('jadwal-pelatihan.*') ? 'active' : '' }}">Tambah Jadwal Pelatihan</a>
            <a href="{{ route('pendaftaran-pelatihan.index') }}" class="{{ request()->routeIs('pendaftaran-pelatihan.*') ? 'active' : '' }}">Data Pendaftar</a>
            <a href="{{ route('admin.pelatih.index') }}" class="{{ request()->routeIs('admin.pelatih.*') ? 'active' : '' }}">Data Pelatih</a>
            
            <!-- Link Menu Sertifikat Pelatihan Aktif -->
            <a href="{{ route('admin.sertifikat.index') }}" class="{{ request()->routeIs('admin.sertifikat.*') ? 'active' : '' }}">Tambah Sertifikat Pelatihan</a>
        </div>
    </div>

    <a href="{{ route('admin.kunjungan.pendaftaran') }}" class="{{ request()->routeIs('admin.kunjungan.*') ? 'active' : '' }}">
        <i class="fas fa-calendar-alt menu-icon"></i> <span>Manajemen Kunjungan</span>
    </a>

    <a href="{{ route('admin.kemitraan.index') }}" class="{{ request()->routeIs('admin.kemitraan.*') ? 'active' : '' }}">
        <i class="fas fa-handshake menu-icon"></i> <span>Manajemen Kemitraan</span>
    </a>

    <a href="{{ route('admin.pesan.index') }}" class="{{ request()->routeIs('admin.pesan.*') ? 'active' : '' }} justify-content-between">
        <div><i class="fas fa-envelope-open-text menu-icon"></i> <span>Pesan Masuk</span></div>
        @php $notif = \App\Models\KontakPesan::count(); @endphp
        @if($notif > 0)
            <span class="badge bg-danger rounded-pill" style="font-size: 0.65rem; padding: 4px 8px;">{{ $notif }}</span>
        @endif
    </a>

    <a href="#cmsMenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/fasilitas*') || request()->is('admin/product*') || request()->is('admin/galeri*') || request()->is('admin/reviews*') || request()->is('admin/profil-website*') ? 'true' : 'false' }}" class="nav-link justify-content-between mt-3 {{ request()->is('admin/fasilitas*') || request()->is('admin/product*') || request()->is('admin/galeri*') || request()->is('admin/reviews*') || request()->is('admin/profil-website*') ? 'text-white' : '' }}">
        <div><i class="fas fa-desktop menu-icon"></i> <span>Manajemen CMS</span></div>
        <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
    </a>
    <div class="collapse {{ request()->is('admin/fasilitas*') || request()->is('admin/product*') || request()->is('admin/galeri*') || request()->is('admin/reviews*') || request()->is('admin/profil-website*') ? 'show' : '' }}" id="cmsMenu">
        <div class="submenu">
            <a href="{{ route('admin.fasilitas.index') }}" class="{{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">Data Fasilitas</a>
            <a href="{{ route('admin.product.index') }}" class="{{ request()->routeIs('admin.product.*') ? 'active' : '' }}">Katalog Produk</a>
            <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">Artikel & Galeri</a>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">Moderasi Review</a>
            <a href="{{ route('profil-website.index') }}" class="{{ request()->routeIs('profil-website.*') ? 'active' : '' }}">Profil Website</a>
        </div>
    </div>

    <hr style="border-color: #374151; margin: 20px 15px;">

    <a href="{{ route('beranda') }}" target="_blank" class="text-muted">
        <i class="fas fa-external-link-alt menu-icon"></i> <span>Lihat Website Front-End</span>
    </a>
</div>

<div class="content">
    <div class="navbar-custom d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-light d-md-none me-3 border shadow-sm">
                <i class="fas fa-bars"></i>
            </button>
            <strong class="text-secondary"><i class="fas fa-shield-alt text-success me-2"></i>Administrator Panel</strong>
        </div>
        
        <div class="dropdown">
            <a class="dropdown-toggle fw-bold text-dark text-decoration-none d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.9rem;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                {{ auth()->user()->name ?? 'Super Admin' }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 10px;">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2 text-secondary"></i> Pengaturan Akun</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger fw-bold"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>