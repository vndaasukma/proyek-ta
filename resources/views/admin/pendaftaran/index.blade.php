@extends('admin.layout')

@section('content')
<h4 class="mb-3">Data Pendaftaran Pelatihan</h4>

<div class="card p-3 shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Pelatihan</th>
                    <th>Tanggal</th>
                    <th>Status Pembayaran</th> {{-- Dari Midtrans --}}
                    <th>Status Admin</th> {{-- Verifikasi Manual --}}
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $item)
                @php 
                    // Kita buat variabel bantuan agar kode lebih bersih dan tidak sensitif huruf besar/kecil
                    $payStatus = strtolower($item->status_pembayaran);
                    $admStatus = strtolower($item->status_pendaftaran);
                @endphp
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ $item->pelatihan->nama_pelatihan ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    
                    {{-- KOLOM STATUS PEMBAYARAN (MIDTRANS) --}}
                    <td>
                        @if($payStatus == 'pending')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock"></i> Belum Bayar
                            </span>
                        @elseif($payStatus == 'success' || $payStatus == 'settlement' || $payStatus == 'capture')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Lunas
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle"></i> Gagal/Expired
                            </span>
                        @endif
                    </td>

                    {{-- KOLOM STATUS ADMIN (PENDAFTARAN) --}}
                    <td>
                        @if($admStatus == 'menunggu' || $admStatus == 'pending')
                            <span class="badge bg-warning text-dark">PENDING</span>
                        @elseif($admStatus == 'disetujui' || $admStatus == 'success')
                            <span class="badge bg-success">SUCCESS</span>
                        @else
                            <span class="badge bg-danger">DITOLAK</span>
                        @endif
                    </td>

                    {{-- KOLOM AKSI --}}
                    <td class="text-center">
                        @if($admStatus == 'menunggu' || $admStatus == 'pending')
                            <div class="btn-group">
                                <form action="{{ route('admin.approve', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui pendaftaran ini?')">Approve</button>
                                </form>

                                <form action="{{ route('admin.tolak', $item->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pendaftaran ini?')">Tolak</button>
                                </form>
                            </div>

                        @elseif($admStatus == 'disetujui' || $admStatus == 'success')
                            <form action="{{ route('admin.batalkan', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Batalkan verifikasi ini?')">
                                    <i class="fas fa-undo"></i> Batalkan
                                </button>
                            </form>

                        @else
                            <span class="text-muted small italic">Sudah ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        Belum ada data pendaftaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection