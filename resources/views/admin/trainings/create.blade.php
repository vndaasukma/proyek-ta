@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Tambah Pelatihan Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas-pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="fw-bold">Nama Pelatihan</label>
                    <input type="text" name="nama_pelatihan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                </div>

                <!-- INPUT TANGGAL -->
                <div class="mb-3">
                    <label class="fw-bold text-primary">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelatihan" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Kuota Maksimal</label>
                        <input type="number" name="kuota" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="tersedia">Tersedia (Muncul di Depan)</option>
                            <option value="tutup">Tutup</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <button type="submit" class="btn btn-success w-100">Simpan Pelatihan</button>
            </form>
        </div>
    </div>
</div>
@endsection