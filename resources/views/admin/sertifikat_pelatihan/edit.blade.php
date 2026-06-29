@extends('admin.layout')

@section('content')
<div class="container-fluid mt-2">
    <div class="mb-4">
        <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-sm btn-light border shadow-sm mb-2">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 text-gray-800 fw-bold">Pengaturan Komponen Sertifikat</h4>
        <p class="text-muted small mb-0">Kelas: <span class="text-dark fw-bold">{{ $pelatihan->title ?? $pelatihan->nama_pelatihan }}</span></p>
    </div>

    <form action="{{ route('admin.sertifikat.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Bagian 1: Pengaturan Template -->
        <div class="card p-4 mb-4 shadow-sm border-0" style="border-radius: 12px;">
            <h5 class="fw-bold text-success mb-3"><i class="fas fa-file-image me-2"></i>Desain Template Dasar</h5>
            
            <div class="mb-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="is_default_template" name="is_default_template" value="1" {{ !$sertifikat || !$sertifikat->template_sertifikat ? 'checked' : '' }} onchange="toggleTemplateInput(this)">
                    <label class="form-check-label fw-medium text-dark" for="is_default_template">Gunakan Template Bingkai Bawaan Sistem</label>
                </div>
                <small class="text-muted d-block mb-3">Jika dicentang, admin hanya perlu menginput komponen teks dan tanda tangan saja tanpa gambar background sertifikat kustom.</small>
            </div>

            <div id="input_template_container" style="{{ !$sertifikat || !$sertifikat->template_sertifikat ? 'display: none;' : '' }}">
                <label class="form-label fw-bold small">Upload Gambar Template Kustom (A4 Landscape)</label>
                <input type="file" name="template_sertifikat" class="form-control mb-2">
                @if($sertifikat && $sertifikat->template_sertifikat)
                    <div class="mt-2">
                        <small class="text-muted d-block mb-1">Template saat ini:</small>
                        <img src="{{ asset('storage/' . $sertifikat->template_sertifikat) }}" style="max-height: 120px; border-radius: 6px;" class="border shadow-sm">
                    </div>
                @endif
            </div>
        </div>

        <!-- Bagian 2: Pengaturan Tanda Tangan (3 Kolom Opsional & Aman dari Null) -->
        <div class="card p-4 mb-4 shadow-sm border-0" style="border-radius: 12px;">
            <h5 class="fw-bold text-primary mb-4"><i class="fas fa-pen-nib me-2"></i>Komponen Penandatangan Sertifikat (Opsional)</h5>
            
            <div class="row g-4">
                <!-- 1. TTD Pelatih / Instruktur (Kiri) -->
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <label class="form-label fw-bold small text-secondary">1. TTD Pelatih / Instruktur (Kiri)</label>
                        <input type="text" name="nama_pelatih" class="form-control mb-2" placeholder="Nama Pelatih & Gelar" value="{{ old('nama_pelatih', $sertifikat?->nama_pelatih ?? $pelatihan->nama_pelatih) }}">
                        <input type="file" name="ttd_pelatih" class="form-control">
                        @if($sertifikat && $sertifikat->ttd_pelatih)
                            <img src="{{ asset('storage/' . $sertifikat->ttd_pelatih) }}" class="mt-2 bg-white p-1 border rounded" style="height: 60px;">
                        @endif
                    </div>
                </div>

                <!-- 2. TTD Penyelenggara (Tengah) -->
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <label class="form-label fw-bold small text-secondary">2. TTD Penyelenggara (Tengah)</label>
                        <input type="text" name="nama_penyelenggara" class="form-control mb-2" placeholder="Nama Lembaga / Penanggungjawab" value="{{ old('nama_penyelenggara', $sertifikat?->nama_penyelenggara) }}">
                        <input type="file" name="ttd_penyelenggara" class="form-control">
                        @if($sertifikat && $sertifikat->ttd_penyelenggara)
                            <img src="{{ asset('storage/' . $sertifikat->ttd_penyelenggara) }}" class="mt-2 bg-white p-1 border rounded" style="height: 60px;">
                        @endif
                    </div>
                </div>

                <!-- 3. TTD Ketua P4S (Kanan) -->
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <label class="form-label fw-bold small text-secondary">3. TTD Ketua P4S (Kanan)</label>
                        <input type="text" name="nama_ketua" class="form-control mb-2" placeholder="Nama Ketua" value="{{ old('nama_ketua', $sertifikat?->nama_ketua ?? 'Supratna S.Pt') }}">
                        <input type="file" name="ttd_ketua" class="form-control">
                        @if($sertifikat && $sertifikat->ttd_ketua)
                            <img src="{{ asset('storage/' . $sertifikat->ttd_ketua) }}" class="mt-2 bg-white p-1 border rounded" style="height: 60px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success px-5 py-2 shadow-sm fw-bold" style="border-radius: 8px;">
                <i class="fas fa-save me-1"></i> Simpan Komponen Sertifikat
            </button>
        </div>
    </form>
</div>

<script>
    function toggleTemplateInput(checkbox) {
        const container = document.getElementById('input_template_container');
        if (checkbox.checked) {
            container.style.display = 'none';
        } else {
            container.style.display = 'block';
        }
    }
</script>
@endsection