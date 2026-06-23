@extends('admin.layout')

@section('content')
<div class="container-fluid mt-2">
    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-gray-800 fw-bold">Manajemen & Kontrol Gembok Kunjungan</h4>
            <p class="text-muted small mb-0">Kelola jadwal instansi sekaligus buka-tutup gembok tanggal kunjungan secara mandiri langsung dari dashboard.</p>
        </div>
    </div>

    <!-- NOTIFIKASI SYSTEM -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3" style="border-radius: 8px;">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-3" style="border-radius: 8px;">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- 📄 KOLOM KIRI: TABEL PENDAFTARAN KUNJUNGAN & AKSI RESCHEDULE (8 COLUMNS) -->
        <div class="col-lg-8 mb-4">
            <div class="card p-3 shadow-sm border-0" style="border-radius: 12px; background: #ffffff;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Instansi / Ketua</th>
                                <th>Tanggal Kunjungan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kunjungan as $item)
                            <tr>
                                <td>
                                    <strong class="text-dark">{{ $item->nama_instansi ?? $item->nama }}</strong><br>
                                    <small class="text-muted"><i class="fas fa-phone fa-xs"></i> {{ $item->no_hp }}</small>
                                </td>
                                <td class="fw-medium text-secondary">
                                    <i class="fas fa-calendar-day me-1 text-primary"></i> {{ \Carbon\Carbon::parse($item->tgl_kunjungan)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    @if($item->status == 'approved' || $item->status == 'disetujui')
                                        <span class="badge bg-success px-2 py-1.5 rounded-pill"><i class="fas fa-check-circle"></i> Disetujui</span>
                                    @elseif($item->status == 'rejected' || $item->status == 'ditolak')
                                        <span class="badge bg-danger px-2 py-1.5 rounded-pill"><i class="fas fa-times-circle"></i> Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1.5 rounded-pill"><i class="fas fa-clock"></i> Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1">
                                        <!-- Tombol Reschedule Memicu Modal Pop-up -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $item->id }}" style="border-radius: 6px;">
                                            <i class="fas fa-clock me-1"></i> Reschedule
                                        </button>

                                        @if(strtolower($item->status) == 'pending' || $item->status == null)
                                            <div class="d-flex gap-1 mt-1">
                                                <form action="{{ route('admin.kunjungan.approve', $item->id) }}" method="POST" class="w-50">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success w-100" style="border-radius: 6px;" title="Setujui">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.kunjungan.reject', $item->id) }}" method="POST" class="w-50">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger w-100" style="border-radius: 6px;" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- Tombol Hapus Riwayat jika sudah selesai diproses -->
                                            <form action="{{ route('admin.kunjungan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran kunjungan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border text-danger w-100 mt-1" style="border-radius: 6px;">
                                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- JENDELA POP-UP (MODAL) INDIVIDU UNTUK RESCHEDULE -->
                            <div class="modal fade" id="rescheduleModal{{ $item->id }}" tabindex="-1" aria-labelledby="rescheduleModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 14px; border: none;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-dark" id="rescheduleModalLabel{{ $item->id }}">
                                                <i class="fas fa-calendar-alt text-primary me-2"></i>Atur Ulang Jadwal
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.kunjungan.reschedule', $item->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body text-start pt-3">
                                                <p class="small text-muted mb-3">Kamu akan memindahkan tanggal pendaftaran kunjungan untuk instansi/kelompok: <br><strong class="text-dark">{{ $item->nama_instansi ?? $item->nama }}</strong>.</p>
                                                <div class="form-group">
                                                    <label class="small fw-bold text-secondary mb-2">Pilih Tanggal Kunjungan Baru</label>
                                                    <input type="date" name="tanggal_baru" class="form-control shadow-sm" value="{{ $item->tgl_kunjungan }}" required style="border-radius: 8px;">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                                                <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px;">Simpan Jadwal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-calendar-times fa-2x mb-2 opacity-50"></i>
                                    <p class="mb-0 small">Belum ada riwayat data pendaftaran kunjungan yang masuk.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 🔒 KOLOM KANAN: PANEL INPUT LOCK & DAFTAR UNLOCK JADWAL MANDIRI (4 COLUMNS) -->
        <div class="col-lg-4 mb-4">
            <!-- FORM INPUT KUNCI JADWAL -->
            <div class="card p-4 border-0 shadow-sm mb-4" style="border-radius: 12px; background: #ffffff;">
                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-lock text-danger me-2"></i>Gembok Tanggal Kunjungan</h6>
                <form action="{{ route('admin.kunjungan.lock') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="small fw-medium text-secondary mb-1">Pilih Tanggal Dikunci</label>
                        <input type="date" name="date" class="form-control shadow-sm" required style="border-radius: 8px;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="small fw-medium text-secondary mb-1">Alasan Penutupan / Gembok</label>
                        <input type="text" name="keterangan" class="form-control shadow-sm" placeholder="Contoh: Libur Instansi / Slot Penuh" required style="border-radius: 8px;">
                    </div>
                    <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold py-2.5 shadow-sm" style="border-radius: 8px; font-size: 0.85rem;">
                        <i class="fas fa-lock me-1"></i> LOCK TANGGAL INI
                    </button>
                </form>
            </div>

            <!-- TABEL DAFTAR TANGGAL YANG SEDANG KE-LOCK -->
            <div class="card p-3 border-0 shadow-sm" style="border-radius: 12px; background: #f8f9fa;">
                <h6 class="fw-bold text-secondary mb-3 small"><i class="fas fa-list me-2"></i>Daftar Tanggal Terkunci ({{ $lockedDates->count() }})</h6>
                <div class="d-flex flex-column gap-2" style="max-height: 290px; overflow-y: auto;">
                    @forelse($lockedDates as $lock)
                        <div class="p-2 bg-white border rounded d-flex justify-content-between align-items-center shadow-sm" style="border-radius: 8px !important;">
                            <div>
                                <span class="d-block text-dark fw-bold small"><i class="fas fa-calendar-times text-danger me-1"></i> {{ date('d-m-Y', strtotime($lock->date)) }}</span>
                                <small class="text-muted" style="font-size: 0.73rem;">{{ $lock->keterangan }}</small>
                            </div>
                            <!-- Akses Unlock/Buka Gembok -->
                            <form action="{{ route('admin.kunjungan.unlock', $lock->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-success p-0 me-1" title="Buka Kunci Gembok" onclick="return confirm('Buka kembali akses kalender kunjungan untuk tanggal ini?')">
                                    <i class="fas fa-unlock-alt fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center text-muted small py-4 bg-white rounded border border-dashed" style="border-radius: 8px !important;">
                            Belum ada tanggal yang kamu gembok mandiri.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection