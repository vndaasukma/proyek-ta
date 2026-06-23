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

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 12px;">
                <form action="{{ route('admin.blast.send') }}" method="POST">
                    @csrf
                    
                    <!-- INFO TARGET -->
                    <div class="alert alert-info border-0 mb-4 small d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg me-2"></i>
                        <div>
                            Pesan akan otomatis dikirimkan ke <strong>{{ $total_peserta }} nomor peserta</strong> yang terdata di sistem saat ini menggunakan token Fonnte Anda.
                        </div>
                    </div>

                    <!-- INPUT TEKS PESAN -->
                    <div class="form-group mb-4">
                        <label for="pesan" class="fw-bold text-dark small mb-2">Isi Pesan WhatsApp Broadcast</label>
                        <textarea name="pesan" id="pesan" rows="10" class="form-control" style="border-radius: 8px; font-size: 0.9rem;" placeholder="Tulis pengumuman di sini...&#10;&#10;Contoh:&#10;Selamat Pagi Peserta Pelatihan, berikut link grup koordinasi P4S Gubuk Sayur: chat.whatsapp.com/xxx" required></textarea>
                        <div class="form-text text-muted" style="font-size: 0.75rem; mt-2">
                            *Tips: Gunakan bintang (*) untuk menebalkan kata (cth: *Tebal*), dan gunakan enter untuk baris baru.
                        </div>
                    </div>

                    <!-- TOMBOL EKSEKUSI -->
                    <button type="submit" class="btn btn-success px-4 w-100 py-2 fw-bold shadow-sm" style="border-radius: 8px;" onclick="return confirm('Apakah Anda yakin ingin mengirimkan pesan blast ini ke seluruh peserta?')">
                        <i class="fab fa-whatsapp me-2"></i> SEBARKAN SEKARANG (BLAST)
                    </button>
                </form>
            </div>
        </div>

        <!-- TEMPLATE PETUNJUK -->
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
@endsection