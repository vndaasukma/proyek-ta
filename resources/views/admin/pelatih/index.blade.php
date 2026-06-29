@extends('admin.layout')
@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4">Manajemen Data Pelatih</h4>

    <!-- Form Tambah -->
    <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 12px;">
        <h6 class="fw-bold mb-3">Tambah Pelatih Baru</h6>
        <form action="{{ route('admin.pelatih.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4"><input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required></div>
            <div class="col-md-3"><input type="text" name="no_wa" class="form-control" placeholder="No WA (Contoh: 62812...)" required></div>
            <div class="col-md-3"><input type="text" name="keahlian" class="form-control" placeholder="Keahlian"></div>
            <div class="col-md-2"><button class="btn btn-success w-100"><i class="fas fa-plus"></i> Simpan</button></div>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Nama</th><th>No WA</th><th>Keahlian</th><th class="text-center">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($pelatih as $p)
                <tr>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->no_wa }}</td>
                    <td>{{ $p->keahlian }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{$p->id}}"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('admin.pelatih.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelatih ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{$p->id}}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.pelatih.update', $p->id) }}" method="POST" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header"><h5 class="modal-title">Edit Pelatih</h5></div>
                            <div class="modal-body">
                                <input type="text" name="nama" value="{{$p->nama}}" class="form-control mb-2" required>
                                <input type="text" name="no_wa" value="{{$p->no_wa}}" class="form-control mb-2" required>
                                <input type="text" name="keahlian" value="{{$p->keahlian}}" class="form-control">
                            </div>
                            <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection