@extends('admin.layout')

@section('content')

<h4 class="mb-3">Tambah Jadwal Kunjungan</h4>

<div class="card p-3">

    <form action="{{ route('kunjungan.store') }}" method="POST">
        @csrf

        <div class="mb-2">
            <label>Judul Kunjungan</label>
            <input type="text" name="judul" class="form-control" placeholder="Contoh: Kunjungan Edukasi">
        </div>

        <div class="mb-2">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control">
        </div>

        <div class="mb-2">
            <label>Jam</label>
            <input type="time" name="jam" class="form-control">
        </div>

        <div class="mb-2">
            <label>Kuota</label>
            <input type="number" name="kuota" class="form-control" value="10">
        </div>

        <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">
            Simpan Jadwal
        </button>

        <a href="{{ route('kunjungan.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

@endsection
