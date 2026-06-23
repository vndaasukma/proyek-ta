@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kelas Pelatihan</h1>
        <a href="{{ route('kelas-pelatihan.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pelatihan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Master Pelatihan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Pelatihan</th>
                            <th>Tanggal</th> 
                            <th>Harga</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatihan as $p)
                        <tr>
                            <td class="text-center">
                                @if($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}" class="rounded shadow-sm" width="80" alt="Identitas Kelas">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td><strong>{{ $p->nama_pelatihan }}</strong></td>
                            <!-- MENAMPILKAN TANGGAL PELATIHAN -->
                            <td>
                                <span class="badge bg-primary px-2 py-1">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $p->tanggal_pelatihan ? \Carbon\Carbon::parse($p->tanggal_pelatihan)->format('d/m/Y') : '-' }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td>{{ $p->kuota }} Peserta</td>
                            <td>
                                <span class="badge {{ $p->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                                    {{ strtoupper($p->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('kelas-pelatihan.edit', $p->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <a href="{{ route('kelas-pelatihan.cetak', $p->id) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Cetak
                                    </a>

                                    <form action="{{ route('kelas-pelatihan.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pelatihan {{ $p->nama_pelatihan }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data pelatihan yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection