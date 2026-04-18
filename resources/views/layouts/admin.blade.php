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
        
        /* SIDEBAR STYLE */
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
        
        /* CONTENT AREA */
        .content { margin-left: 260px; padding: 25px; min-height: 100vh; }
        
        /* NAVBAR TOP */
        .navbar-custom {
            background: white; padding: 15px 25px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        /* CUSTOM BADGE */
        .badge-notif { font-size: 0.7rem; padding: 0.35em 0.65em; }
    </style>
</head>
<body>

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

    <hr class="mx-3 opacity-25">
    
    <a href="/" target="_blank">
        <i class="fas fa-external-link-alt me-2"></i> Lihat Website
    </a>
</div>

<div class="content">
    <div class="navbar-custom d-flex justify-content-between align-items-center">
        <div class="fw-bold text-secondary text-capitalize">
            @if(request()->is('admin/dashboard')) dashboard 
            @elseif(request()->is('admin/pendaftaran-kunjungan*')) manajemen kunjungan 
            @elseif(request()->is('admin/kemitraan*')) manajemen kemitraan
            @elseif(request()->is('admin/pesan*')) pesan masuk
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>