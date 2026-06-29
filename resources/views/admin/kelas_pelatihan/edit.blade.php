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
                    <input type="text" name="nama_pelatihan" class="form-control" value="{{ old('nama_pelatihan', $pelatihan->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pelatihan</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $pelatihan->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold text-success">Syarat & Ketentuan Pelatihan</label>
                    <textarea name="ketentuan" class="form-control" rows="4" required>{{ old('ketentuan', $pelatihan->ketentuan) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-primary">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelatihan" class="form-control" value="{{ old('tanggal_pelatihan', $pelatihan->tanggal_pelatihan ? $pelatihan->tanggal_pelatihan->format('Y-m-d') : '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-danger">Batas Akhir Pendaftaran</label>
                        <input type="date" name="batas_pendaftaran" class="form-control" value="{{ old('batas_pendaftaran', $pelatihan->tanggal_exp_pelatihan ? $pelatihan->tanggal_exp_pelatihan->format('Y-m-d') : '') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga', $pelatihan->price) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Kuota Peserta</label>
                        <input type="number" name="kuota" class="form-control" value="{{ old('kuota', $pelatihan->quota) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Status <span class="text-danger">*Harap pilih Close jika belum add jadwal</span></label>
                        <select name="status" class="form-control">
                            <option value="open" {{ old('status', $pelatihan->status) == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="closed" {{ old('status', $pelatihan->status) == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label font-weight-bold">Ubah Gambar Identitas Kelas</label>
                        <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        @if($pelatihan->gambar) 
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" style="height:80px;" class="mt-2 rounded border shadow-sm d-block"> 
                        @endif
                    </div>
                </div>

                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Update Pelatihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection