@extends('admin.layout')

@section('content')
<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-handshake me-2"></i> Manajemen Kemitraan</h6>
    </div>
    <div class="card-body">
        <h3 class="mb-4 text-dark font-weight-bold" style="letter-spacing: -1px;">Manajemen Kemitraan.</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" style="background-color: #d1e7dd; color: #0f5132;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-dark">
                    <tr>
                        <th class="text-none">Nama/instansi</th>
                        <th class="text-none">No Whatsapp</th>
                        <th class="text-none text-center">Proposal</th>
                        <th class="text-none text-center">Status</th>
                        <th class="text-none text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kemitraan as $item)
                    @php
                        // LOGIKA CERDAS: Mengubah format 08 menjadi 628 untuk WhatsApp API
                        $noWa = preg_replace('/[^0-9]/', '', $item->no_wa);
                        if (substr($noWa, 0, 1) == '0') {
                            $noWa = '62' . substr($noWa, 1);
                        }
                        
                        // Membuat template pesan otomatis untuk mempermudah Admin
                        $waMessage = "Halo Bapak/Ibu " . $item->nama_perwakilan . " dari " . $item->nama_instansi . ".\n\nKami dari pengelola P4S Gubuk Sayur Lumajang ingin menindaklanjuti pengajuan proposal kemitraan Anda pada sistem kami. Apakah kita bisa berdiskusi lebih lanjut terkait hal tersebut?";
                        $waLink = "https://wa.me/" . $noWa . "?text=" . urlencode($waMessage);
                    @endphp
                    <tr>
                        <td>
                            <strong class="text-dark">{{ $item->nama_instansi }}</strong><br>
                            <small class="text-muted">oleh: {{ $item->nama_perwakilan }}</small>
                        </td>
                        <td>{{ $item->no_wa }}</td>
                        <td class="text-center">
                            @if($item->proposal_path)
                                <a href="{{ asset('storage/' . $item->proposal_path) }}" target="_blank" class="btn btn-sm text-white" style="background-color: #00d1e0; border-radius: 6px;">
                                    lihat file
                                </a>
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2" style="border-radius: 6px;">Pending</span>
                            @elseif($item->status == 'approved')
                                <span class="badge bg-success px-3 py-2" style="border-radius: 6px;">Approved</span>
                            @elseif($item->status == 'rejected')
                                <span class="badge bg-secondary px-3 py-2" style="border-radius: 6px;">Rejected</span>
                            @else
                                <span class="badge bg-light text-dark px-3 py-2">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                
                                <a href="{{ $waLink }}" target="_blank" class="btn btn-sm text-white" style="background-color: #25D366; border-radius: 6px;" title="Chat via WhatsApp">
                                    <i class="fab fa-whatsapp"></i> Chat WA
                                </a>

                                @if($item->status == 'pending')
                                    <button type="button" class="btn btn-primary btn-sm px-3" style="border-radius: 6px;" onclick="openConfirmModal('approve', '{{ $item->id }}', '{{ $item->nama_instansi }}')">
                                        Terima
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm px-3" style="border-radius: 6px; background-color: #6c757d;" onclick="openConfirmModal('reject', '{{ $item->id }}', '{{ $item->nama_instansi }}')">
                                        tolak
                                    </button>
                                @elseif($item->status == 'approved')
                                    <a href="{{ route('admin.kemitraan.cetak', $item->id) }}" class="btn btn-danger btn-sm px-3" style="border-radius: 6px;" target="_blank">
                                        <i class="fas fa-file-pdf"></i> cetak surat
                                    </a>

                                    <form action="{{ route('admin.kemitraan.kirim', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm px-3" style="border-radius: 6px;" onclick="return confirm('Kirim berkas PDF surat persetujuan resmi ke Email & WhatsApp pengaju?')">
                                            <i class="fas fa-paper-plane"></i> Kirim Surat
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.kemitraan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengajuan kemitraan ini secara permanen?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-outline-secondary btn-sm" style="border-radius: 6px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4" id="modalBody">
                </div>
            <div class="modal-footer border-0 d-flex justify-content-center bg-light" style="border-radius: 0 0 16px 16px;">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <a href="#" class="btn px-4 fw-bold" id="btnConfirm" style="border-radius: 8px;">Ya, Lanjutkan</a>
            </div>
        </div>
    </div>
</div>

<script>
    function openConfirmModal(action, id, instansiName) {
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const btnConfirm = document.getElementById('btnConfirm');

        if (action === 'approve') {
            btnConfirm.href = '/admin/kemitraan/' + id + '/approve';
            modalTitle.innerHTML = '<i class="fas fa-check-circle me-2"></i>Konfirmasi Terima';
            modalTitle.className = 'modal-title fw-bold text-primary';
            modalBody.innerHTML = `
                <div class="mb-3"><i class="fas fa-handshake text-primary" style="font-size: 4rem;"></i></div>
                <h5 class="mb-2 text-dark">Yakin ingin <strong>MENERIMA</strong> pengajuan dari <br><span class="text-primary">${instansiName}</span>?</h5>
                <p class="text-muted small mb-0 mt-2">Pastikan Anda sudah berdiskusi dan mencapai kesepakatan dengan PIC terkait. Status akan diubah menjadi <strong>Approved</strong>.</p>
            `;
            btnConfirm.className = 'btn btn-primary';
            btnConfirm.innerHTML = 'Ya, Terima Kemitraan';
        } 
        else if (action === 'reject') {
            btnConfirm.href = '/admin/kemitraan/' + id + '/reject';
            modalTitle.innerHTML = '<i class="fas fa-times-circle me-2"></i>Konfirmasi Tolak';
            modalTitle.className = 'modal-title fw-bold text-danger';
            modalBody.innerHTML = `
                <div class="mb-3"><i class="fas fa-exclamation-circle text-danger" style="font-size: 4rem;"></i></div>
                <h5 class="mb-2 text-dark">Yakin ingin <strong>MENOLAK</strong> pengajuan dari <br><span class="text-danger">${instansiName}</span>?</h5>
                <p class="text-muted small mb-0 mt-2">Data ini akan ditandai sebagai <strong>Rejected</strong> pada sistem.</p>
            `;
            btnConfirm.className = 'btn btn-danger';
            btnConfirm.innerHTML = 'Ya, Tolak Kemitraan';
        }

        var actionModal = new bootstrap.Modal(document.getElementById('actionModal'));
        actionModal.show();
    }
</script>
@endsection