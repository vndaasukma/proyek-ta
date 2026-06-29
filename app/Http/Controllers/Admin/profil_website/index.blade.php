@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Profil Website</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Halaman "Tentang Kami"</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('profil-website.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3">1. Bagian Utama</h5>
                <div class="mb-3">
                    <label>Judul Utama</label>
                    <input type="text" name="judul" class="form-control" value="{{ $profil->judul }}" required>
                </div>
                <div class="mb-4">
                    <label>Deskripsi Utama</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required>{{ $profil->deskripsi }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5 class="font-weight-bold text-success border-bottom pb-2 mb-3">2. Kotak Visi</h5>
                        <div class="mb-3">
                            <label>Judul Visi</label>
                            <input type="text" name="visi_judul" class="form-control" value="{{ $profil->visi_judul }}" required>
                        </div>
                        <div class="mb-4">
                            <label>Deskripsi Visi</label>
                            <textarea name="visi_deskripsi" class="form-control" rows="2" required>{{ $profil->visi_deskripsi }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="font-weight-bold text-info border-bottom pb-2 mb-3">3. Kotak Edukasi</h5>
                        <div class="mb-3">
                            <label>Judul Edukasi</label>
                            <input type="text" name="edukasi_judul" class="form-control" value="{{ $profil->edukasi_judul }}" required>
                        </div>
                        <div class="mb-4">
                            <label>Deskripsi Edukasi</label>
                            <textarea name="edukasi_deskripsi" class="form-control" rows="2" required>{{ $profil->edukasi_deskripsi }}</textarea>
                        </div>
                    </div>
                </div>

                <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3 mt-3">4. Media Gambar</h5>
                <div class="mb-4">
                    <label>Gambar Greenhouse / Dokumentasi</label>
                    <div class="mb-2">
                        @if($profil->gambar)
                            <img src="{{ asset('storage/' . $profil->gambar) }}" width="300" class="rounded shadow-sm">
                        @else
                            <div class="p-3 bg-light text-muted rounded border" style="width: 300px; text-align: center;">Belum ada gambar</div>
                        @endif
                    </div>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save"></i> Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection