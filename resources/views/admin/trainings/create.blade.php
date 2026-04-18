@extends('admin.layout')

@section('content')
<h1>Tambah Pelatihan</h1>

<form action="/admin/trainings/store" method="POST">
    @csrf

    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="title" class="form-control">
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control">
    </div>

    <div class="mb-3">
        <label>Kuota</label>
        <input type="number" name="quota" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="open">Open</option>
            <option value="closed">Closed</option>
        </select>
    </div>

    <button class="btn btn-success">Simpan</button>
</form>
@endsection
