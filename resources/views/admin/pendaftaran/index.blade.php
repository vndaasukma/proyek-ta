@extends('admin.layout')

@section('content')
<div class="container-fluid mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-gray-800 fw-bold">Data Pendaftaran Pelatihan</h4>
            <p class="text-muted small mb-0">Seluruh pendaftaran diproses secara otomatis oleh sistem setelah pembayaran Midtrans sukses.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBlastMassal">
                <i class="fas fa-mail-bulk me-1"></i> Blast Sertifikat Massal
            </button>

            <a href="{{ route('admin.blast.view') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-bullhorn me-1"></i> Buat Blast WA
            </a>
            
            <button type="button" class="btn btn-info shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalHubungiPelatih">
                <i class="fas fa-user-tie me-1"></i> Hubungi Pelatih
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-3">{{ session('error') }}</div>
    @endif

    <div class="card p-3 shadow-sm border-0" style="border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Peserta & Kontak</th>
                        <th>Pelatihan</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-center">Pembayaran</th>
                        <th class="text-center">Status Admin</th>
                        <th class="text-center" style="width: 200px;">Aksi & Koordinasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $item)
                    @php 
                        $payStatus = strtolower($item->status_pembayaran);
                        $admStatus = strtolower($item->status_pendaftaran);
                        $noWa = preg_replace('/[^0-9]/', '', $item->no_hp);
                        if (substr($noWa, 0, 1) == '0') { $noWa = '62' . substr($noWa, 1); }
                    @endphp
                    <tr>
                        <td>
                            <strong class="text-dark">{{ $item->nama }}</strong><br>
                            <small class="text-muted"><i class="fas fa-envelope"></i> {{ $item->email }}</small><br>
                            <small class="text-success"><i class="fab fa-whatsapp"></i> {{ $item->no_hp }}</small>
                        </td>
                        <td class="fw-medium text-secondary">
                            {{ $item->pelatihan->title ?? $item->pelatihan->nama_pelatihan ?? '-' }}
                        </td>
                        <td class="text-secondary fw-medium">
                            {{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d-m-Y') }}
                        </td>
                        <td class="text-center">
                            @if($payStatus == 'success' || $payStatus == 'settlement' || $payStatus == 'capture')
                                <span class="badge bg-success px-2 py-1.5 rounded-pill"><i class="fas fa-check-circle"></i> Lunas</span>
                            @elseif($payStatus == 'pending')
                                <span class="badge bg-warning text-dark px-2 py-1.5 rounded-pill"><i class="fas fa-clock"></i> Belum Bayar</span>
                            @else
                                <span class="badge bg-danger px-2 py-1.5 rounded-pill"><i class="fas fa-times-circle"></i> Gagal</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($admStatus == 'disetujui' || $admStatus == 'success')
                                <span class="badge bg-success px-2 py-1">SUCCESS</span>
                            @else
                                <span class="badge bg-warning text-dark px-2 py-1">PENDING</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-1">
                                <a href="https://wa.me/{{ $noWa }}" target="_blank" class="btn btn-sm btn-outline-success w-100" style="border-radius: 6px;">
                                    <i class="fab fa-whatsapp"></i> Chat Peserta
                                </a>

                                @if($payStatus == 'success' || $payStatus == 'settlement' || $payStatus == 'capture')
                                    <div class="d-flex gap-1 mt-1">
                                        <a href="{{ route('admin.pendaftaran.preview_sertifikat', $item->id) }}" target="_blank" class="btn btn-sm btn-primary py-1 px-2 w-50" style="font-size: 0.75rem; border-radius: 6px;">
                                            <i class="fas fa-eye"></i> Preview
                                        </a>
                                        <form action="{{ route('admin.pendaftaran.blast_sertifikat', $item->id) }}" method="POST" class="m-0 w-50" onsubmit="return confirm('Kirim berkas PDF sertifikat resmi ke email {{ $item->email }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success py-1 px-2 w-100" style="font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-certificate"></i> Kirim
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted border py-2" style="font-size: 0.75rem;">
                                        <i class="fas fa-robot"></i> Pending
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0 small">Belum ada data pendaftaran pelatihan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBlastMassal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-mail-bulk me-2"></i> Blast Sertifikat Kelompok</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pendaftaran.blast_massal') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <label class="form-label fw-bold">Pilih Kelompok Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        @foreach($list_kelas as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->title ?? $kelas->nama_pelatihan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Kirim Massal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHubungiPelatih" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-user-tie me-2"></i>Hubungi Pelatih</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Pilih Pelatih:</label>
                    <select id="selectPelatih" class="form-control" onchange="document.getElementById('linkWa').href='https://wa.me/'+this.value">
                        <option value="">-- Pilih Pelatih --</option>
                        @foreach(\App\Models\Pelatih::all() as $p)
                            <option value="{{ $p->no_wa }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <a id="linkWa" href="#" target="_blank" class="btn btn-success w-100"><i class="fab fa-whatsapp me-2"></i> Chat WhatsApp</a>
            </div>
        </div>
    </div>
</div>
@endsection