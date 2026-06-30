@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-primary text-uppercase">Manajemen Artikel & Galeri Foto</h5>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0" style="padding-left: 15px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 bg-light rounded-4 border">
                        @csrf
                        <h6 class="fw-bold mb-3 text-dark"><i class="fas fa-plus-circle me-2"></i>Tambah Artikel Kegiatan Baru</h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Judul Artikel / Kegiatan</label>
                                <input type="text" name="judul" class="form-control" placeholder="Misal: Panen Selada Hidroponik Bersama Siswa SMK" value="{{ old('judul') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Pilih Gambar Cover</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase">Isi Artikel / Deskripsi Lengkap</label>
                                <textarea name="deskripsi" class="form-control" rows="5" placeholder="Ceritakan detail kegiatan secara lengkap di sini... (Anda bisa menggunakan tombol Enter untuk membuat paragraf baru)">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                                    <i class="fas fa-save me-1"></i> Simpan Artikel
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="row">
                        @forelse($galeri as $item)
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $item->judul }}">
                                <div class="card-body p-3 d-flex flex-column">
                                    <h6 class="fw-bold mb-1 text-dark text-truncate" title="{{ $item->judul }}">{{ $item->judul }}</h6>

                                    <p class="small text-muted mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $item->deskripsi ?? 'Belum ada isi artikel.' }}
                                    </p>

                                    <div class="d-flex gap-1 mt-auto">
                                        <button type="button" class="btn btn-sm btn-outline-primary w-50 rounded-pill" data-bs-toggle="modal" data-bs-target="#editGaleriModal{{ $item->id }}">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>

                                        <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="w-50 m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel kegiatan ini?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit Artikel --}}
                        <div class="modal fade" id="editGaleriModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                                    <div class="modal-header bg-white border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-primary"><i class="fas fa-edit me-2"></i>Ubah Artikel Kegiatan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.galeri.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-uppercase text-muted">Judul Artikel / Kegiatan</label>
                                                <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-uppercase text-muted">Isi Artikel / Deskripsi Lengkap</label>
                                                <textarea name="deskripsi" class="form-control" rows="5">{{ $item->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-uppercase text-muted">Ganti Gambar Cover (opsional)</label>
                                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                                <div class="mt-3 text-center bg-light p-2 rounded-3 border">
                                                    <small class="text-muted d-block mb-1 fw-medium">Gambar Saat Ini:</small>
                                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="rounded border shadow-sm" style="height: 110px; max-width: 100%; object-fit: cover;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 12px 12px;">
                                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-sm px-4" style="border-radius: 6px;">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3 opacity-50"></i>
                            <p class="text-muted italic">Belum ada koleksi artikel atau foto galeri.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection