@extends('layouts.frontend')

@section('content')
<style>
    .training-detail-header {
        background-color: #052216; /* Warna hijau tua sesuai screenshot */
        color: #ffffff;
        padding: 40px 0;
    }
    .training-detail-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }
    .training-detail-header p {
        font-size: 0.95rem;
        opacity: 0.7;
    }
    .main-content-wrap {
        padding: 50px 0;
        background-color: #ffffff;
    }
    .left-card-box {
        background: #ffffff;
    }
    .left-card-box h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #000000;
    }
    .left-card-box .syarat-title {
        color: #198754;
    }
    .left-card-box img {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    .terms-box {
        background-color: #f8fafc;
        border-left: 4px solid #198754;
        padding: 25px;
        border-radius: 0 12px 12px 0;
    }
    .right-sticky-card {
        border: 1px solid #eef0f2;
        border-radius: 16px;
        background: #ffffff;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        position: sticky;
        top: 100px;
    }
    .right-sticky-card h2 {
        color: #198754;
        font-weight: 700;
        font-size: 1.8rem;
    }
    .meta-info-item {
        font-size: 0.9rem;
        color: #334155;
    }
    .meta-info-item i {
        font-size: 1.1rem;
        width: 25px;
        text-align: center;
    }
    .btn-start-learn {
        background-color: #198754;
        color: white;
        font-weight: 600;
        padding: 12px;
        border-radius: 8px;
        border: none;
        transition: background 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-start-learn:hover {
        background-color: #146c43;
        color: white;
    }
</style>

<header class="training-detail-header">
    <div class="container">
        <h1 class="mb-2">{{ $pelatihan->nama_pelatihan }}</h1>
        <p class="mb-0">Program Human Resource Development P4S Gubuk Sayur</p>
    </div>
</header>

<main class="main-content-wrap">
    <div class="container">
        <div class="row g-5">
            
            <div class="col-lg-8">
                <div class="left-card-box">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/' . $pelatihan->gambar) }}" class="w-100 img-fluid" style="max-height: 480px; object-fit: cover;" alt="{{ $pelatihan->nama_pelatihan }}">
                    </div>

                    <h3 class="mb-3">Deskripsi Kelas</h3>
                    <p class="text-secondary mb-5" style="white-space: pre-line; line-height: 1.8; font-size: 1.05rem;">
                        {{ $pelatihan->deskripsi }}
                    </p>

                    <h3 class="mb-3 syarat-title">Syarat & Ketentuan Pelatihan</h3>
                    <div class="terms-box mb-4">
                        <p class="text-dark mb-0" style="white-space: pre-line; line-height: 1.8; font-size: 0.95rem;">
                            {{ $pelatihan->ketentuan }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="right-sticky-card">
                    <h2 class="mb-4">
                        @if($pelatihan->harga > 0)
                            Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </h2>

                    <div class="mb-4 d-flex flex-column gap-3">
                        <div class="meta-info-item d-flex align-items-center">
                            <i class="far fa-calendar-alt text-success me-3"></i>
                            <div>
                                <span class="text-muted d-block small" style="font-size: 0.8rem;">Pelaksanaan:</span>
                                <span class="fw-semibold">{{ $pelatihan->tanggal_pelatihan ? $pelatihan->tanggal_pelatihan->format('d F Y') : '-' }}</span>
                            </div>
                        </div>

                        <div class="meta-info-item d-flex align-items-center">
                            <i class="fas fa-hourglass-end text-danger me-3"></i>
                            <div>
                                <span class="text-muted d-block small" style="font-size: 0.8rem;">Batas Pendaftaran:</span>
                                <span class="fw-semibold">{{ $pelatihan->batas_pendaftaran ? $pelatihan->batas_pendaftaran->format('d F Y') : '-' }}</span>
                            </div>
                        </div>

                        <div class="meta-info-item d-flex align-items-center">
                            <i class="fas fa-users text-primary me-3"></i>
                            <div>
                                <span class="text-muted d-block small" style="font-size: 0.8rem;">Sisa Kuota:</span>
                                <span class="fw-semibold">{{ ($pelatihan->kuota - $pelatihan->terisi) }} Kursi Tersedia</span>
                            </div>
                        </div>
                    </div>

                    @if($pelatihan->status == 'open' && ($pelatihan->kuota - $pelatihan->terisi) > 0)
                        <a href="{{ route('pelatihan.daftar', $pelatihan->id) }}" class="btn-start-learn w-100">
                            mulai belajar <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <button class="btn btn-secondary w-100 py-2.5 fw-bold" disabled style="border-radius: 8px;">
                            Pendaftaran Ditutup
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</main>
@endsection