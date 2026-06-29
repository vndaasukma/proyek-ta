@extends('admin.layout')

@section('content')
<div class="container-fluid p-0">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3" style="border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" style="border-radius: 8px;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-5 mb-3 mb-md-0">
            <div class="card shadow border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-radius: 12px 12px 0 0;">
                    <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-lock me-2"></i> Gembok Tanggal Kunjungan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kunjungan.lock') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="small fw-bold text-secondary mb-1">Pilih Tanggal Tutup</label>
                            <input type="date" name="date" class="form-control shadow-sm" required style="border-radius: 8px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="small fw-bold text-secondary mb-1">Alasan / Keterangan</label>
                            <input type="text" name="keterangan" class="form-control shadow-sm" placeholder="Contoh: Acara Internal / Libur" required style="border-radius: 8px;">
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold py-2 shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-lock me-1"></i> LOCK TANGGAL INI
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-radius: 12px 12px 0 0;">
                    <h6 class="m-0 font-weight-bold text-secondary"><i class="fas fa-list me-2"></i> Tanggal Terkunci Saat Ini ({{ $lockedDates->count() }})</h6>
                </div>
                <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                    <div class="row g-2 px-2">
                        @forelse($lockedDates as $lock)
                            <div class="col-sm-6">
                                <div class="p-2 bg-white border rounded d-flex justify-content-between align-items-center shadow-sm" style="border-radius: 8px !important;">
                                    <div>
                                        <span class="d-block text-dark fw-bold small"><i class="fas fa-calendar-times text-danger me-1"></i> {{ date('d M Y', strtotime($lock->date)) }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $lock->keterangan }}</small>
                                    </div>
                                    <form action="{{ route('admin.kunjungan.unlock', $lock->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-success p-0 me-1" title="Buka Kunci" onclick="return confirm('Buka kembali akses kunjungan untuk tanggal ini?')">
                                            <i class="fas fa-unlock-alt fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted small py-4">Belum ada tanggal yang kamu gembok mandiri.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-radius: 12px 12px 0 0;">
                    <h6 class="m-0 font-weight-bold text-success mb-0"><i class="fas fa-calendar-alt me-2"></i>  Manajemen Permohonan Kunjungan</h6>
                    <button type="button" class="btn btn-success btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addManualModal" style="border-radius: 8px;">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Kunjungan Manual
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="padding-left: 20px;">Pemohon & Instansi</th>
                                    <th>Kontak</th>
                                    <th>Waktu Kunjungan</th>
                                    <th>Tujuan / Keperluan</th>
                                    <th>Status</th>
                                    <th class="text-center" style="padding-right: 20px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_pendaftaran as $item)
                                <tr>
                                    <td style="padding-left: 20px;">
                                        <strong class="text-dark">{{ $item->nama_pemohon }}</strong><br>
                                        <small class="text-muted fw-medium">{{ $item->instansi }}</small>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold small"><i class="fab fa-whatsapp"></i> {{ $item->no_wa }}</span><br>
                                        <small class="text-muted">{{ $item->email }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-secondary">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</span><br>
                                        <span class="badge bg-info text-dark mt-1" style="font-size: 0.75rem;">
                                            Sesi {{ $item->sesi }} (@if($item->sesi == 1) 08:00 @elseif($item->sesi == 2) 10:00 @else 13:30 @endif)
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-muted small mb-0" style="max-width: 260px; white-space: normal; word-wrap: break-word; line-height: 1.4;">
                                            {{ $item->keperluan ?? '-' }}
                                        </p>
                                    </td>
                                    <td>
                                        @if($item->status == 'pending') <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                        @elseif($item->status == 'approved') <span class="badge bg-success px-3 py-2">Approved</span>
                                        @else <span class="badge bg-danger px-3 py-2">Rejected</span> @endif
                                    </td>
                                    <td class="text-center" style="padding-right: 20px;">
                                        <div class="d-flex gap-1 justify-content-center align-items-center">
                                            @if($item->status == 'pending')
                                                <button type="button" class="btn btn-success btn-sm fw-bold px-2" onclick="openConfirmModal('approve', '{{ $item->id }}', '{{ $item->instansi }}')" title="Terima">
                                                    <i class="fas fa-check"></i>
                                                </button>

                                                <button type="button" class="btn btn-danger btn-sm fw-bold px-2" onclick="openConfirmModal('reject', '{{ $item->id }}', '{{ $item->instansi }}')" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- VALIDASI FRONTEND: Sembunyikan tombol reschedule jika tanggal kunjungan sudah lewat -->
                                            @if(\Carbon\Carbon::parse($item->tanggal_kunjungan)->startOfDay()->gte(\Carbon\Carbon::today()))
                                                <button type="button" class="btn btn-outline-primary btn-sm px-2" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $item->id }}" title="Reschedule Jadwal">
                                                    <i class="fas fa-clock"></i>
                                                </button>
                                            @endif

                                            <form action="{{ route('admin.kunjungan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data reservasi ini secara permanen?')" class="m-0">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-secondary btn-sm px-2"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="rescheduleModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                                            <div class="modal-header bg-white border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-clock text-primary me-2"></i>Reschedule Tanggal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.kunjungan.reschedule', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body text-start">
                                                    <p class="small text-muted">Ubah tanggal reservasi untuk pemohon: <br><strong>{{ $item->nama_pemohon }} ({{ $item->instansi }})</strong></p>
                                                    <div class="form-group">
                                                        <label class="small fw-bold text-secondary mb-2">Pilih Tanggal Baru</label>
                                                        <input type="date" name="tanggal_baru" class="form-control" value="{{ $item->tanggal_kunjungan }}" required style="border-radius: 8px;">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 12px 12px;">
                                                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                                                    <button type="submit" class="btn btn-primary btn-sm px-4" style="border-radius: 6px;">Simpan Jadwal Baru</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addManualModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header bg-white border-0 pb-0">
                <h5 class="modal-title fw-bold text-success"><i class="fas fa-plus-circle me-2"></i>Tambah Kunjungan Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.kunjungan.store_manual') }}" method="POST">
                @csrf
                <div class="modal-body text-start">
                    <div class="mb-2">
                        <label class="small fw-bold text-secondary mb-1">Nama Lengkap Pemohon</label>
                        <input type="text" name="nama_pemohon" class="form-control form-control-sm" placeholder="Nama Ketua / Penanggungjawab" required style="border-radius: 6px;">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold text-secondary mb-1">Nama Instansi / Kelompok</label>
                        <input type="text" name="instansi" class="form-control form-control-sm" placeholder="Contoh: Kelompok Tani Sukamaju" required style="border-radius: 6px;">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold text-secondary mb-1">Nomor WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control form-control-sm" placeholder="08xxxxxxxxxx" required style="border-radius: 6px;">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold text-secondary mb-1">Alamat Email</label>
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="nama@email.com" required style="border-radius: 6px;">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="small fw-bold text-secondary mb-1">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" class="form-control form-control-sm" required style="border-radius: 6px;">
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold text-secondary mb-1">Sesi Kunjungan</label>
                            <select name="sesi" class="form-select form-select-sm" required style="border-radius: 6px;">
                                <option value="1">Sesi 1 (08.00 WIB)</option>
                                <option value="2">Sesi 2 (10.00 WIB)</option>
                                <option value="3">Sesi 3 (13.30 WIB)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="small fw-bold text-secondary mb-1">Keperluan / Catatan</label>
                        <textarea name="keperluan" class="form-control form-control-sm" rows="2" placeholder="Tujuan kunjungan edukasi..." style="border-radius: 6px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-4" style="border-radius: 6px;">Simpan Kunjungan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="confirmForm" method="POST" action="">
                @csrf
                <div class="modal-body text-center py-4" id="modalBody">
                    </div>
                <div class="modal-footer border-0 d-flex justify-content-center bg-light" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary px-4 fw-bold btn-sm" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn px-4 fw-bold btn-sm" id="btnConfirm" style="border-radius: 6px;">Ya, Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openConfirmModal(action, id, instansiName) {
        const form = document.getElementById('confirmForm');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const btnConfirm = document.getElementById('btnConfirm');

        if (action === 'approve') {
            form.action = '/admin/pendaftaran-kunjungan/' + id + '/approve';
            modalTitle.innerHTML = '<i class="fas fa-check-circle me-2"></i>Konfirmasi Terima Kunjungan';
            modalTitle.className = 'modal-title fw-bold text-success';
            modalBody.innerHTML = `
                <div class="mb-3"><i class="fas fa-check-circle text-success" style="font-size: 3.5rem;"></i></div>
                <h5 class="mb-2" style="font-size:1.1rem;">Apakah Anda yakin ingin <strong>MENERIMA</strong> kunjungan dari <span class="text-success">${instansiName}</span>?</h5>
                <p class="text-muted small mb-0">Sistem akan otomatis mengirimkan notifikasi <strong>Persetujuan</strong> ke WhatsApp dan Email pemohon.</p>
            `;
            btnConfirm.className = 'btn btn-success btn-sm';
            btnConfirm.innerHTML = 'Ya, Terima Kunjungan';
        } 
        else if (action === 'reject') {
            form.action = '/admin/pendaftaran-kunjungan/' + id + '/reject';
            modalTitle.innerHTML = '<i class="fas fa-times-circle me-2"></i>Konfirmasi Tolak Kunjungan';
            modalTitle.className = 'modal-title fw-bold text-danger';
            modalBody.innerHTML = `
                <div class="mb-3"><i class="fas fa-exclamation-circle text-danger" style="font-size: 3.5rem;"></i></div>
                <h5 class="mb-2" style="font-size:1.1rem;">Apakah Anda yakin ingin <strong>MENOLAK</strong> kunjungan dari <span class="text-danger">${instansiName}</span>?</h5>
                <p class="text-muted small mb-0">Sistem akan otomatis mengirimkan notifikasi <strong>Penolakan</strong> ke WhatsApp dan Email pemohon.</p>
            `;
            btnConfirm.className = 'btn btn-danger btn-sm';
            btnConfirm.innerHTML = 'Ya, Tolak Kunjungan';
        }

        var actionModal = new bootstrap.Modal(document.getElementById('actionModal'));
        actionModal.show();
    }
</script>
@endsection