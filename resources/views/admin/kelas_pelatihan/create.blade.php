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

                <div class="mb-3">
                    <label class="form-label font-weight-bold text-success">Syarat & Ketentuan Pelatihan</label>
                    <textarea name="ketentuan" class="form-control @error('ketentuan') is-invalid @enderror" rows="4" placeholder="Contoh: Peserta wajib membawa catatan, hadir 15 menit sebelum acara, dll...">{{ old('ketentuan') }}</textarea>
                    <small class="text-muted">Ini wajib dibaca peserta di halaman detail sebelum mereka mengisi form pendaftaran.</small>
                    @error('ketentuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-primary">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelatihan" class="form-control @error('tanggal_pelatihan') is-invalid @enderror" value="{{ old('tanggal_pelatihan') }}" required>
                        <small class="text-info">Jadwal pelatihan dilaksanakan.</small>
                        @error('tanggal_pelatihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-danger">Batas Akhir Pendaftaran (Exp)</label>
                        <input type="date" name="tanggal_exp_pelatihan" class="form-control @error('tanggal_exp_pelatihan') is-invalid @enderror" value="{{ old('tanggal_exp_pelatihan') }}" required>
                        <small class="text-danger">Pendaftaran otomatis ditutup setelah melewati tanggal ini.</small>
                        @error('tanggal_exp_pelatihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" placeholder="Contoh: 50000" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Kuota Maksimal</label>
                        <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota') }}" placeholder="Contoh: 20" required>
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Status Awal</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Tersedia (Bisa Didaftar)</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Ditutup Sementara</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">Nama Instruktur / Pelatih</label>
                        <input type="text" name="nama_pelatih" class="form-control @error('nama_pelatih') is-invalid @enderror" value="{{ old('nama_pelatih') }}" placeholder="Contoh: Dr. Ir. Ahmad Subarjo, M.P." required>
                        <small class="text-muted">Nama ini yang akan dicantumkan secara resmi di lembar sertifikat.</small>
                        @error('nama_pelatih')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">Scan Tanda Tangan Pelatih (.PNG Transparan)</label>
                        <input type="file" name="ttd_pelatih" class="form-control @error('ttd_pelatih') is-invalid @enderror" accept="image/png" required>
                        <small class="text-success font-weight-bold">Format wajib .PNG transparan (tanpa background) maks 2MB.</small>
                        @error('ttd_pelatih')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label font-weight-bold">Gambar Identitas Kelas</label>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                    <small class="text-info">Format: JPG, PNG, JPEG (Max 2MB). Ini untuk cover brosur halaman depan.</small>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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