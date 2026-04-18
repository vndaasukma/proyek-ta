@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pelatihan Baru</h1>
        <a href="{{ route('kelas-pelatihan.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Pendaftaran Master Pelatihan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas-pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Pelatihan</label>
                    <input type="text" name="nama_pelatihan" class="form-control @error('nama_pelatihan') is-invalid @enderror" value="{{ old('nama_pelatihan') }}" placeholder="Contoh: Pelatihan Tanam Wortel Organik" required>
                    @error('nama_pelatihan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pelatihan</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Jelaskan detail materi, lokasi, atau persyaratan pelatihan di sini...">{{ old('deskripsi') }}</textarea>
                    <small class="text-muted">Informasi ini akan muncul di halaman pengunjung agar mereka tertarik mendaftar.</small>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 50000" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Kuota Maksimal</label>
                        <input type="number" name="kuota" class="form-control" placeholder="Contoh: 20" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Status Awal</label>
                        <select name="status" class="form-control">
                            <option value="open">Open (Bisa Didaftar)</option>
                            <option value="closed">Closed (Ditutup Sementara)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label font-weight-bold">Gambar Identitas Kelas</label>
                    <input type="file" name="gambar" class="form-control">
                    <small class="text-info">Format: JPG, PNG, JPEG (Max 2MB).</small>
                </div>

                <hr>
                <div class="text-end">
                    <button type="reset" class="btn btn-light px-4 me-2">Reset</button>
                    <button type="submit" class="btn btn-success px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Simpan Pelatihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection