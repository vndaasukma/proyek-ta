@extends('layouts.admin')

@section('content')
<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-calendar-alt me-2"></i> Manajemen Kunjungan</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Pemohon & Instansi</th>
                        <th>Kontak</th>
                        <th>Waktu Kunjungan</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_pendaftaran as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->nama_pemohon }}</strong><br>
                            <small class="text-muted">{{ $item->instansi }}</small>
                        </td>
                        <td>
                            <span class="text-success"><i class="fab fa-whatsapp"></i> {{ $item->no_wa }}</span><br>
                            <small class="text-muted">{{ $item->email }}</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}<br>
                            <span class="badge bg-info text-dark">
                                Sesi {{ $item->sesi }} (@if($item->sesi == 1) 08:00 @elseif($item->sesi == 2) 10:00 @else 13:30 @endif)
                            </span>
                        </td>
                        <td>
                            <small>{{ $item->keperluann ?? '-' }}</small>
                        </td>
                        <td>
                            @if($item->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($item->status == 'approved') <span class="badge bg-success">Approved</span>
                            @else <span class="badge bg-danger">Rejected</span> @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($item->status == 'pending')
                                    <form action="/admin/pendaftaran-kunjungan/{{ $item->id }}/approve" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> TERIMA
                                        </button>
                                    </form>

                                    <form action="/admin/pendaftaran-kunjungan/{{ $item->id }}/reject" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> TOLAK
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.kunjungan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-secondary btn-sm"><i class="fas fa-trash"></i></button>
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
@endsection