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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <ul class="mb-0" style="padding-left: 15px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 bg-light rounded-4 border">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-uppercase text-muted">nama produk</label>
                                <input type="text" name="judul" class="form-control rounded-pill border-0 shadow-sm" placeholder="misal: sawi hidroponik segar" value="{{ old('judul') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">foto produk</label>
                                <input type="file" name="gambar" class="form-control rounded-pill border-0 shadow-sm" accept="image/jpeg,image/png,image/jpg" required>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100 rounded-pill shadow-sm fw-bold">
                                    <i class="fas fa-plus me-1"></i> tambah produk
                                </button>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-uppercase text-muted">deskripsi produk</label>
                                <textarea name="deskripsi" rows="2" class="form-control rounded-4 border-0 shadow-sm" placeholder="tulis deskripsi singkat produk di sini...">{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4 opacity-25">

                    <div class="row">
                        @forelse($products as $p)
                        <div class="col-md-3 col-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $p->image_path) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $p->title }}">

                                <div class="card-body p-3">
                                    <p class="small fw-bold mb-1 text-truncate text-lowercase">{{ $p->title }}</p>
                                    <p class="small text-muted mb-3" style="min-height: 36px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $p->deskripsi ?? 'belum ada deskripsi.' }}
                                    </p>

                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary w-50 rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}">
                                            <i class="fas fa-edit me-1"></i> edit
                                        </button>

                                        <form action="{{ route('admin.product.destroy', $p->id) }}" method="POST" class="w-50 m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill" onclick="return confirm('hapus produk ini?')">
                                                <i class="fas fa-trash me-1"></i> hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                                    <div class="modal-header bg-white border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-success"><i class="fas fa-edit me-2"></i>ubah data produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.product.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-uppercase text-muted">nama produk baru</label>
                                                <input type="text" name="judul" class="form-control rounded-pill shadow-sm" value="{{ $p->title }}" required style="padding: 10px 18px;">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-uppercase text-muted">deskripsi produk</label>
                                                <textarea name="deskripsi" rows="3" class="form-control rounded-4 shadow-sm" placeholder="tulis deskripsi singkat produk di sini...">{{ $p->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-uppercase text-muted">ganti foto produk (opsional)</label>
                                                <input type="file" name="gambar" class="form-control rounded-pill shadow-sm" accept="image/jpeg,image/png,image/jpg">
                                                <div class="mt-3 text-center bg-light p-2 rounded-3 border">
                                                    <small class="text-muted d-block mb-1 fw-medium">Visualisasi Foto Saat Ini:</small>
                                                    <img src="{{ asset('storage/' . $p->image_path) }}" class="rounded border shadow-sm" style="height: 90px; max-width: 100%; object-fit: cover;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 12px 12px;">
                                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal" style="border-radius: 6px;">batal</button>
                                            <button type="submit" class="btn btn-success btn-sm px-4" style="border-radius: 6px;">simpan perubahan</button>
                                        </div>
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