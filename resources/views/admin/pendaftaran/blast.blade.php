@extends('admin.layout')

@section('content')
<div class="container-fluid mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-gray-800 fw-bold"><i class="fas fa-bullhorn text-success me-2"></i>Blast WhatsApp Pengumuman</h4>
            <p class="text-muted small mb-0">Kirim pesan massal, rundown, atau tautan grup koordinasi ke seluruh peserta dalam sekali klik.</p>
        </div>
        <a href="{{ route('pendaftaran-pelatihan.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm"><i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 12px;">
                <form action="{{ route('admin.blast.send') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label for="pelatihan_id" class="fw-bold text-dark small mb-2">Pilih Kelas Pelatihan <span class="text-danger">*</span></label>
                        <select name="pelatihan_id" id="pelatihan_id" class="form-control" style="border-radius: 8px;" required>
                            <option value="">-- Pilih Pelatihan yang akan di-blast --</option>
                            @foreach($list_pelatihan as $kelas)
                                @php
                                    // Menghitung jumlah peserta yang sudah LUNAS khusus di kelas ini
                                    $jumlah_lunas = \App\Models\PendaftaranPelatihan::where('pelatihan_id', $kelas->id)
                                        ->whereIn('status_pembayaran', ['Success', 'success', 'settlement', 'capture'])
                                        ->count();
                                @endphp
                                <option value="{{ $kelas->id }}" data-peserta="{{ $jumlah_lunas }}">
                                    {{ $kelas->title ?? $kelas->nama_pelatihan }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="alert alert-info border-0 mb-4 small d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg me-2"></i>
                        <div>
                            Pesan akan otomatis dikirimkan ke <strong id="angka_target">0</strong><strong> nomor peserta (Status Lunas)</strong> yang terdata di sistem untuk kelas yang dipilih.
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="pesan" class="fw-bold text-dark small mb-2">Isi Pesan WhatsApp Broadcast</label>
                        <textarea name="pesan" id="pesan" rows="10" class="form-control" style="border-radius: 8px; font-size: 0.9rem;" placeholder="Tulis pengumuman di sini...&#10;&#10;Contoh:&#10;Selamat Pagi Peserta Pelatihan, berikut link grup koordinasi P4S Gubuk Sayur: chat.whatsapp.com/xxx" required></textarea>
                        <div class="form-text text-muted" style="font-size: 0.75rem; margin-top: 8px;">
                            *Tips: Gunakan bintang (*) untuk menebalkan kata (cth: *Tebal*), dan gunakan enter untuk baris baru.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success px-4 w-100 py-2 fw-bold shadow-sm" style="border-radius: 8px;" onclick="return confirm('Pastikan isi pesan dan kelas yang dipilih sudah benar. Lanjutkan Blast WA?')">
                        <i class="fab fa-whatsapp me-2"></i> SEBARKAN SEKARANG (BLAST)
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4 bg-light border-0 shadow-sm" style="border-radius: 12px;">
                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-lightbulb text-warning me-2"></i>Contoh Format Pesan</h6>
                <div class="p-3 bg-white border rounded text-secondary" style="font-size: 0.85rem; line-height: 1.6; border-radius: 8px;">
                    *PENGUMUMAN PELATIHAN P4S GUBUK SAYUR*<br><br>
                    Halo rekan-rekan peserta, menyusul pembayaran yang telah berhasil dikonfirmasi oleh sistem, berikut detail teknis pelaksanaan:<br><br>
                    📅 *Tanggal:* Sesuai Jadwal<br>
                    ⏰ *Waktu:* 08:00 WIB - Selesai<br>
                    📍 *Lokasi:* P4S Gubuk Sayur Lumajang<br><br>
                    Silakan bergabung ke dalam grup koordinasi resmi WhatsApp melalui tautan berikut:<br>
                    👉 https://chat.whatsapp.com/GubukSayurExample<br><br>
                    Sampai jumpa di lokasi!
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownPelatihan = document.getElementById('pelatihan_id');
        const teksAngkaTarget = document.getElementById('angka_target');

        dropdownPelatihan.addEventListener('change', function() {
            // Ambil opsi (option) yang sedang dipilih/diklik
            const opsiTerpilih = this.options[this.selectedIndex];
            
            // Tarik angka dari data-peserta, jika kosong jadikan 0
            const jumlahPeserta = opsiTerpilih.getAttribute('data-peserta') || 0;
            
            // Ubah teks di dalam HTML
            teksAngkaTarget.innerText = jumlahPeserta;
        });
    });
</script>
@endsection