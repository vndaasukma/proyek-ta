@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kelas Pelatihan</h1>
        
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-info text-white shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-calendar-plus fa-sm text-white-50 me-1"></i> Tambah Jadwal
                </button>
                <ul class="dropdown-menu shadow border-0 mt-1" style="border-radius: 8px;">
                    <li class="dropdown-header text-primary fw-bold">Pilih Kelas:</li>
                    @forelse($pelatihan as $p)
                        <li>
                            <a class="dropdown-item py-2" href="#">
                                <i class="fas fa-seedling text-success me-2"></i> {{ $p->nama_pelatihan }}
                            </a>
                        </li>
                    @empty
                        <li><span class="dropdown-item text-muted">Belum ada master kelas</span></li>
                    @endforelse </ul>
            </div>

            <a href="{{ route('kelas-pelatihan.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pelatihan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div id="successAlert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Master Pelatihan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="10%">Gambar</th>
                            <th>Nama Pelatihan</th>
                            <th width="20%">Tanggal</th> 
                            <th>Harga</th>
                            <th class="text-center">Kuota</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatihan as $p)
                        <tr>
                            <td class="text-center">
                                @if($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}" class="rounded shadow-sm" style="width: 80px; height: 60px; object-fit: cover;" alt="Identitas Kelas">
                                @else
                                    <span class="badge bg-secondary p-2">No Image</span>
                                @endif
                            </td>
                            <td><strong class="text-dark">{{ $p->nama_pelatihan }}</strong></td>
                            
                            <td>
                                <div class="mb-1">
                                    <span class="badge bg-primary px-2 py-1 shadow-sm" title="Tanggal Acara Berlangsung">
                                        <i class="fas fa-calendar-alt me-1"></i> Acara:
                                        {{ $p->tanggal_pelatihan ? $p->tanggal_pelatihan->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="badge bg-danger px-2 py-1 shadow-sm" title="Batas Akhir Pendaftaran">
                                        <i class="fas fa-stopwatch me-1"></i> Tutup: 
                                        {{ $p->batas_pendaftaran ? $p->batas_pendaftaran->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                            </td>

                            <td class="fw-bold text-success">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td class="text-center"><span class="badge bg-info text-dark">{{ $p->kuota }} Peserta</span></td>
                            
                            <td class="text-center">
                                <span class="badge {{ $p->status == 'open' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                    {{ strtoupper($p->status) }}
                                </span>
                            </td>
                            
                            <td class="text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <a href="{{ route('kelas-pelatihan.edit', $p->id) }}" class="btn btn-sm btn-warning text-dark fw-bold">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('kelas-pelatihan.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus pelatihan {{ $p->nama_pelatihan }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-folder-open fa-3x mb-3 text-light"></i><br>
                                Belum ada data pelatihan yang tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease-out";
                alert.style.opacity = "0";
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 3000);
        }
    });
</script>
@endsection