@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pelatihan</h1>
        <a href="{{ route('kelas-pelatihan.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Data Pelatihan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas-pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Pelatihan</label>
                    <input type="text" name="nama_pelatihan" class="form-control @error('nama_pelatihan') is-invalid @enderror" value="{{ old('nama_pelatihan', $pelatihan->title ?? $pelatihan->nama_pelatihan) }}" required>
                    @error('nama_pelatihan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pelatihan</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" required>{{ old('deskripsi', $pelatihan->description ?? $pelatihan->deskripsi) }}</textarea>
                    <small class="text-muted">Jelaskan materi pelatihan secara detail di sini.</small>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold text-success">Syarat & Ketentuan Pelatihan</label>
                    <textarea name="ketentuan" class="form-control @error('ketentuan') is-invalid @enderror" rows="4" placeholder="Contoh: Peserta wajib membawa catatan, hadir 15 menit sebelum acara, dll..." required>{{ old('ketentuan', $pelatihan->ketentuan) }}</textarea>
                    <small class="text-muted">Ini wajib dibaca peserta di halaman detail sebelum mereka mengisi form pendaftaran.</small>
                    @error('ketentuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-primary">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelatihan" class="form-control @error('tanggal_pelatihan') is-invalid @enderror" value="{{ old('tanggal_pelatihan', $pelatihan->tanggal_pelatihan) }}" required>
                        @error('tanggal_pelatihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-danger">Batas Akhir Pendaftaran (Exp)</label>
                        <input type="date" name="tanggal_exp_pelatihan" class="form-control @error('tanggal_exp_pelatihan') is-invalid @enderror" value="{{ old('tanggal_exp_pelatihan', $pelatihan->tanggal_exp_pelatihan) }}" required>
                        @error('tanggal_exp_pelatihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $pelatihan->price ?? $pelatihan->harga) }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Kuota Peserta</label>
                        <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota', $pelatihan->quota ?? $pelatihan->kuota) }}" required>
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="open" {{ old('status', $pelatihan->status) == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="closed" {{ old('status', $pelatihan->status) == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 🟢 SEKSI UPDATE DATA BARU: NAMA PELATIH & FILE SCAN TTD PELATIH -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">Nama Instruktur / Pelatih</label>
                        <input type="text" name="nama_pelatih" class="form-control @error('nama_pelatih') is-invalid @enderror" value="{{ old('nama_pelatih', $pelatihan->nama_pelatih) }}" placeholder="Contoh: Dr. Ir. Ahmad Subarjo, M.P." required>
                        <small class="text-muted">Nama pelatih aktif yang bertanggung jawab pada materi kelas ini.</small>
                        @error('nama_pelatih')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">Ubah Tanda Tangan Pelatih (.PNG Transparan)</label>
                        <input type="file" name="ttd_pelatih" class="form-control @error('ttd_pelatih') is-invalid @enderror" accept="image/png">
                        <small class="text-muted d-block mb-2">Biarkan kosong jika tidak ada perubahan pada tanda tangan instruktur.</small>
                        @error('ttd_pelatih')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($pelatihan->ttd_pelatih)
                            <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                                <small class="text-success font-weight-bold d-block mb-1"><i class="fas fa-file-image me-1"></i> TTD Saat Ini:</small>
                                <img src="{{ asset('storage/' . $pelatihan->ttd_pelatih) }}" style="max-height: 60px; object-fit: contain; background-color: #eaeaea; padding: 4px; border-radius: 4px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label font-weight-bold">Gambar Identitas Kelas</label>
                    <div class="mb-2">
                        @if($pelatihan->gambar)
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" class="rounded shadow-sm" width="150" alt="Identitas Kelas Saat Ini">
                            <p class="small text-muted mt-1">Gambar saat ini</p>
                        @else
                            <div class="p-3 bg-light text-muted rounded text-center" style="width: 150px;">
                                <i class="fas fa-image fa-2x"></i><br>No Image
                            </div>
                        @endif
                    </div>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                    <small class="text-info">Pilih file baru jika ingin mengganti gambar (Max 2MB).</small>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                    <i class="fas fa-save"></i> Update Pelatihan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection