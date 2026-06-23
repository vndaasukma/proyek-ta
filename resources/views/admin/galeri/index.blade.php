@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-primary" style="text-transform: lowercase;">manajemen galeri foto</h5>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Input -->
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 bg-light rounded-4">
                        @csrf
                        <div class="row align-items-end g-3">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-uppercase">judul foto</label>
                                <input type="text" name="judul" class="form-control rounded-pill" placeholder="misal: panen selada hidroponik" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase">pilih gambar</label>
                                <input type="file" name="gambar" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">unggah sekarang</button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <!-- Daftar Gambar -->
                    <div class="row">
                        @forelse($galeri as $item)
                        <div class="col-md-3 col-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $item->judul }}">
                                <div class="card-body p-3">
                                    <p class="small fw-bold mb-3 text-truncate">{{ $item->judul }}</p>
                                    <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill" onclick="return confirm('hapus foto ini?')">
                                            <i class="fas fa-trash me-1"></i> hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted italic">belum ada koleksi foto galeri.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection