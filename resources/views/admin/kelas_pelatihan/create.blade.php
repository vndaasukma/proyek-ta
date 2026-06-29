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
            <h6 class="m-0 font-weight-bold text-primary">Formulir Data Pelatihan Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas-pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Pelatihan</label>
                    <input type="text" name="nama_pelatihan" class="form-control" value="{{ old('nama_pelatihan') }}" placeholder="Masukkan nama kelas pelatihan..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pelatihan</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan penjelasan materi pelatihan..." required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold text-success">Syarat & Ketentuan Pelatihan</label>
                    <textarea name="ketentuan" class="form-control" rows="4" placeholder="Masukkan kriteria atau syarat wajib bagi pendaftar..." required>{{ old('ketentuan') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-primary">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelatihan" class="form-control" value="{{ old('tanggal_pelatihan') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-danger">Batas Akhir Pendaftaran</label>
                        <input type="date" name="batas_pendaftaran" class="form-control" value="{{ old('batas_pendaftaran') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Harga pendaftaran (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" placeholder="Contoh: 50000" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Kuota Peserta</label>
                        <input type="number" name="kuota" class="form-control" value="{{ old('kuota') }}" placeholder="Contoh: 20" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Status <span class="text-danger">*Harap pilih Close jika belum add jadwal</span></label>
                        <select name="status" class="form-control">
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label font-weight-bold">Gambar Identitas Kelas (Brosur)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Format file yang didukung: JPEG, JPG, PNG (Maksimal ukuran 2MB)</small>
                    </div>
                </div>

                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-5 shadow-sm fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Pelatihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection