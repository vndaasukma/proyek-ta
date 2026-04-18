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
                    <input type="text" name="nama_pelatihan" class="form-control" value="{{ $pelatihan->nama_pelatihan }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pelatihan</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ $pelatihan->deskripsi }}</textarea>
                    <small class="text-muted">Jelaskan materi pelatihan secara detail di sini.</small>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $pelatihan->harga }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Kuota Peserta</label>
                        <input type="number" name="kuota" class="form-control" value="{{ $pelatihan->kuota }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="open" {{ $pelatihan->status == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="closed" {{ $pelatihan->status == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
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
                    <input type="file" name="gambar" class="form-control">
                    <small class="text-info">Pilih file baru jika ingin mengganti gambar (Max 2MB).</small>
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