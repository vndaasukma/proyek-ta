@extends('admin.layout')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kelas Pelatihan</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Pelatihan
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Master Pelatihan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Pelatihan</th>
                            <th>Jadwal</th>
                            <th>Harga</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $training)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $training->image ? asset('storage/'.$training->image) : asset('images/no-image.png') }}" width="100" class="rounded shadow-sm">
                            </td>
                            <td><strong>{{ $training->title }}</strong></td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    {{ $training->tanggal_pelatihan ? \Carbon\Carbon::parse($training->tanggal_pelatihan)->format('d/m/Y') : '-' }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($training->price, 0, ',', '.') }}</td>
                            <td>{{ $training->quota }} Peserta</td>
                            <td>
                                <span class="badge {{ $training->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                                    {{ strtoupper($training->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $training->id }}">Edit</button>
                                    <form action="/admin/trainings/{{ $training->id }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="/admin/trainings" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelatihan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Pelatihan</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal Pelatihan</label>
                    <input type="date" name="tanggal_pelatihan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kuota Peserta</label>
                    <input type="number" name="quota" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">Simpan Pelatihan</button>
            </div>
        </form>
    </div>
</div>
@endsection