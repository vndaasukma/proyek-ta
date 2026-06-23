@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">pesan masuk pengunjung.</h1>
            <p class="text-muted small mb-0">kelola semua pertanyaan dan saran dari formulir hubungi kami.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-success rounded-pill px-3 py-2">
                total: {{ $pesans->count() }} pesan
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small fw-bold text-muted">
                            <th class="px-4 py-3">tanggal</th>
                            <th>pengirim</th>
                            <th>kontak</th>
                            <th>isi pesan</th>
                            <th class="text-center">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesans as $p)
                        <tr>
                            <td class="px-4 small text-muted">
                                {{ $p->created_at->format('d/m/Y') }}<br>
                                <span class="text-lowercase">{{ $p->created_at->format('H:i') }} wib</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->nama }}</div>
                                <div class="small text-muted text-lowercase">{{ $p->alamat ?? 'alamat tidak diisi' }}</div>
                            </td>
                            <td>
                                <div class="small"><i class="fas fa-envelope me-1 text-success"></i> {{ $p->email }}</div>
                                <div class="small"><i class="fab fa-whatsapp me-1 text-success"></i> {{ $p->no_hp }}</div>
                            </td>
                            <td>
                                <div class="text-muted small" style="max-width: 300px; line-height: 1.4;">
                                    {{ $p->pesan }}
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.pesan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('apakah kamu yakin ingin menghapus pesan dari {{ $p->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="hapus pesan">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                                    <p class="text-muted">belum ada pesan yang masuk saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th { border-bottom: none; }
    .table tbody td { border-bottom: 1px solid #f8f9fa; padding-top: 15px; padding-bottom: 15px; }
    .btn-outline-danger:hover { background-color: #dc3545; color: white; }
    .badge.bg-success { background-color: #198754 !important; }
</style>
@endsection