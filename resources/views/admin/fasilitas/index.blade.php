@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="m-0 fw-bold text-success text-none">
                <i class="fas fa-building me-2"></i>Manajemen Fasilitas P4S
            </h5>
        </div>
        <div class="card-body">
            <!-- Form Tambah Fasilitas -->
            <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 bg-light rounded-4 border">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="small fw-bold text-none text-muted mb-1">Nama Fasilitas</label>
                        <input type="text" name="nama_fasilitas" class="form-control rounded-3" placeholder="misal: green house a" required>
                    </div>
                    <div class="col-md-4">
                        <label class="small fw-bold text-none text-muted mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control rounded-3" placeholder="deskripsi singkat fasilitas" required>
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-none text-muted mb-1">Foto Fasilitas</label>
                        <input type="file" name="gambar" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold text-none">Simpan</button>
                    </div>
                </div>
            </form>

            <!-- Daftar Fasilitas -->
            <div class="row g-3">
                @forelse($fasilitas as $f)
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <img src="{{ asset('storage/' . $f->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Fasilitas">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-none mb-1">{{ $f->nama_fasilitas }}</h6>
                            <p class="small text-muted mb-3">{{ $f->deskripsi }}</p>
                            
                            <form action="{{ route('admin.fasilitas.destroy', $f->id) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill text-none">
                                    <i class="fas fa-trash me-1"></i>hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted fst-italic">belum ada data fasilitas. silakan tambah melalui form di atas.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
