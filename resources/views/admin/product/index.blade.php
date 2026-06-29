@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-success" style="text-transform: lowercase;">manajemen produk kami</h5>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Tambah Produk -->
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 bg-light rounded-4 border">
                        @csrf
                        <div class="row align-items-end g-3">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-uppercase text-muted">nama produk</label>
                                <input type="text" name="judul" class="form-control rounded-pill border-0 shadow-sm" placeholder="misal: sawi hidroponik segar" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">foto produk</label>
                                <input type="file" name="gambar" class="form-control rounded-pill border-0 shadow-sm" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success w-100 rounded-pill shadow-sm fw-bold">
                                    <i class="fas fa-plus me-1"></i> tambah produk
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4 opacity-25">

                    <!-- Daftar Produk -->
                    <div class="row">
                        @forelse($products as $p)
                        <div class="col-md-3 col-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <!-- Perbaikan: Menggunakan image_path sesuai database -->
                                <img src="{{ asset('storage/' . $p->image_path) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $p->title }}">
                                
                                <div class="card-body p-3">
                                    <!-- Perbaikan: Menggunakan title sesuai database -->
                                    <p class="small fw-bold mb-3 text-truncate text-lowercase">{{ $p->title }}</p>
                                    
                                    <form action="{{ route('admin.product.destroy', $p->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill" onclick="return confirm('hapus produk ini?')">
                                            <i class="fas fa-trash me-1"></i> hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted fst-italic">belum ada produk yang diunggah.</div>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
