@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Jadwal & Agenda Pelatihan</h1>
        
        <div class="dropdown">
            <button class="btn btn-info text-white shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-calendar-plus me-1"></i> Tambah Jadwal
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-1" style="border-radius: 8px;">
                <li class="dropdown-header text-primary fw-bold">Pilih Kelas Pelatihan:</li>
                @forelse($kelasPelatihan as $p)
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('jadwal-pelatihan.create', $p->id) }}">
                            <i class="fas fa-seedling text-success me-2"></i> {{ $p->nama_pelatihan }}
                        </a>
                    </li>
                @empty
                    <li><span class="dropdown-item text-muted">Belum ada kelas pelatihan</span></li>
                @endforelse
            </ul>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @forelse($kelasPelatihan as $kp)
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fas fa-seedling me-2"></i>{{ $kp->nama_pelatihan }}
            </h6>
            <div class="btn-group">
                <a href="{{ route('jadwal-pelatihan.create', $kp->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Isi Agenda
                </a>
                <form action="{{ route('jadwal-pelatihan.blast', $kp->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning text-dark font-weight-bold" onclick="return confirm('Kirim email blast pengingat jadwal ke semua peserta kelas ini?')">
                        <i class="fas fa-envelope me-1"></i> Blast Pengingat Email
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%">Waktu</th>
                            <th>Materi / Aktivitas</th>
                            <th>Keterangan</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kp->jadwal as $index => $j)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB
                                </span>
                            </td>
                            <td><strong>{{ $j->materi }}</strong></td>
                            <td class="text-muted small">{{ $j->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('jadwal-pelatihan.destroy', $j->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus agenda jam ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">
                                <i class="fas fa-calendar-times me-1"></i> Agenda detail untuk kelas ini belum diisi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="card p-5 text-center text-muted shadow-sm">
        <i class="fas fa-folder-open fa-3x mb-3 text-light"></i><br>Belum ada data master kelas pelatihan tersedia.
    </div>
    @endforelse
</div>
@endsection