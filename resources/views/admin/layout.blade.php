<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin P4S</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { background-color: #f5f6fa; }
        .sidebar {
            width: 250px; height: 100vh; position: fixed;
            background: #111827; color: white; padding-top: 20px;
        }
        .sidebar a {
            color: #9ca3af; text-decoration: none; display: block;
            padding: 12px 20px; border-radius: 8px; margin: 4px 10px; transition: 0.3s;
        }
        .sidebar a:hover { background: #1f2933; color: white; }
        .sidebar a.active { background: #198754; color: white; }
        
        .content { margin-left: 260px; padding: 25px; }
        .navbar-custom {
            background: white; padding: 10px 20px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h5 class="text-center mb-4">🌱 Admin P4S</h5>

    <a href="{{ route('admin.dashboard') }}"
       class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        📊 Dashboard
    </a>

    <a href="{{ route('kelas-pelatihan.index') }}"
       class="{{ request()->is('admin/kelas-pelatihan*') ? 'active' : '' }}">
        🎓 Kelas Pelatihan
    </a>

    <a href="{{ route('pendaftaran-pelatihan.index') }}"
       class="{{ request()->is('admin/pendaftaran-pelatihan*') ? 'active' : '' }}">
        📝 Pendaftaran
    </a>

    <a href="{{ route('admin.kunjungan.pendaftaran') }}"
       class="{{ request()->is('admin/pendaftaran-kunjungan*') ? 'active' : '' }}">
        📅 Kunjungan
    </a>

    <a href="{{ route('admin.pesan.index') }}"
       class="{{ request()->is('admin/pesan*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
        <span>📩 Pesan Masuk</span>
        @php $notif = \App\Models\KontakPesan::count(); @endphp
        @if($notif > 0)
            <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">{{ $notif }}</span>
        @endif
    </a>
</div>

<div class="content">
    <div class="navbar-custom d-flex justify-content-between align-items-center mb-4">
        <div><strong>Admin Panel</strong></div>
        <div class="dropdown">
            <a class="dropdown-toggle text-dark text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                👤 {{ auth()->user()->name ?? 'Admin' }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">🚪 Logout</button>
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