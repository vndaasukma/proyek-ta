@extends('admin.layout')

@section('content')
<!-- @author Vinda Ambitha Sukma -->
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Isi Agenda Jadwal</h1>
        <a href="{{ route('jadwal-pelatihan.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Menambahkan Sesi Untuk: {{ $kelas->nama_pelatihan }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal-pelatihan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_pelatihan_id" value="{{ $kelas->id }}">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Tanggal Sesi</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $kelas->tanggal_pelatihan ? $kelas->tanggal_pelatihan->format('Y-m-d') : '') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label font-weight-bold">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Materi / Nama Aktivitas Sesi</label>
                    <input type="text" name="materi" class="form-control" placeholder="Contoh: Pembukaan & Pengenalan Teori Hidroponik Sesi 1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Peserta wajib membawa alat tulis..."></textarea>
                </div>

                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Simpan Sesi Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection