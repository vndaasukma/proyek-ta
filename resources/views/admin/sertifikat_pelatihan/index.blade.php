@extends('admin.layout')

@section('content')
<div class="container-fluid mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-gray-800 fw-bold">Komponen Sertifikat Pelatihan</h4>
            <p class="text-muted small mb-0">Atur template dasar dan tanda tangan instruktur secara mandiri per kelas pelatihan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
    @endif

    <div class="card p-3 shadow-sm border-0" style="border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Kelas Pelatihan</th>
                        <th>Status Pengaturan</th>
                        <th>Template Sertifikat</th>
                        <th class="text-center" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihan as $item)
                    <tr>
                        <td class="fw-bold text-dark">
                            {{ $item->title ?? $item->nama_pelatihan }}
                        </td>
                        <td>
                            @if($item->pengaturanSertifikat)
                                <span class="badge bg-success px-2 py-1.5 rounded-pill"><i class="fas fa-check-circle me-1"></i> Sudah Diatur</span>
                            @else
                                <span class="badge bg-warning text-dark px-2 py-1.5 rounded-pill"><i class="fas fa-exclamation-triangle me-1"></i> Belum Diatur</span>
                            @endif
                        </td>
                        <td>
                            @if($item->pengaturanSertifikat && $item->pengaturanSertifikat->template_sertifikat)
                                <small class="text-success fw-medium"><i class="fas fa-image me-1"></i> Template Kustom</small>
                            @else
                                <small class="text-muted"><i class="fas fa-robot me-1"></i> Bawaan Sistem</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.sertifikat.edit', $item->id) }}" class="btn btn-sm btn-primary px-3 shadow-sm" style="border-radius: 6px;">
                                <i class="fas fa-cog me-1"></i> Atur Komponen
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0 small">Belum ada data kelas pelatihan yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection