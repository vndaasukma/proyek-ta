@extends('layouts.frontend')

@section('content')
@php
    /* Mengambil setting warna tema aktif Gubuk Sayur */
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
@endphp

<style>
    :root { --p4s-green: {{ $themeColor }}; }
    .hero-detail { background-color: #0a1f13; color: white; padding: 60px 0; }
    .detail-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .btn-daftar { background-color: var(--p4s-green); color: white; border-radius: 12px; font-weight: bold; padding: 12px 25px; transition: 0.3s; border: none; text-transform: lowercase; }
    .btn-daftar:hover { background-color: #000; color: white; transform: translateY(-2px); }
</style>

<div class="hero-detail">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-success mb-2 px-3 py-2" style="border-radius: 50px;">
                    {{ $pelatihan->status == 'open' ? 'TERSEDIA' : 'DITUTUP' }}
                </span>
                <h1 class="fw-bold text-white">{{ $pelatihan->nama_pelatihan }}</h1>
                <p class="fs-5 opacity-75 text-white-50">Program Human Resource Development P4S Gubuk Sayur</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card detail-card mb-4">
                @if($pelatihan->gambar)
                    <img src="{{ asset('storage/' . $pelatihan->gambar) }}" class="card-img-top" alt="{{ $pelatihan->nama_pelatihan }}" style="height: 400px; object-fit: cover;">
                @endif
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-3">Deskripsi Kelas</h4>
                    <p class="text-muted mb-5" style="line-height: 1.8;">{{ $pelatihan->deskripsi }}</p>

                    <h4 class="fw-bold mb-3 text-success">Syarat & Ketentuan Pelatihan</h4>
                    <div class="bg-light p-4 rounded-4 text-dark" style="border-left: 5px solid var(--p4s-green); border-radius: 12px; line-height: 1.7;">
                        {!! nl2br(e($pelatihan->ketentuan ?? 'Tidak ada syarat dan ketentuan khusus untuk mengikuti pelatihan ini.')) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card detail-card p-4 sticky-top" style="top: 100px; background: white;">
                <h3 class="fw-bold mb-4" style="color: var(--p4s-green)">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</h3>
                
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 border-bottom pb-2">
                        <i class="fas fa-calendar-alt text-success me-2"></i> 
                        <strong>Pelaksanaan:</strong> <br>
                        <span class="text-muted ms-4">{{ $pelatihan->tanggal_pelatihan ? \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->format('d F Y') : 'Jadwal Menyusul' }}</span>
                    </li>
                    <li class="mb-3 border-bottom pb-2">
                        <i class="fas fa-hourglass-end text-danger me-2"></i> 
                        <strong>Batas Pendaftaran:</strong> <br>
                        <span class="text-muted ms-4">{{ $pelatihan->tanggal_exp_pelatihan ? \Carbon\Carbon::parse($pelatihan->tanggal_exp_pelatihan)->format('d F Y') : 'Tanpa Batasan' }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-users text-primary me-2"></i> 
                        <strong>Sisa Kuota:</strong> <br>
                        <span class="text-muted ms-4">{{ $pelatihan->kuota - ($pelatihan->terisi ?? 0) }} Kursi Tersedia</span>
                    </li>
                </ul>

                @php
                    $isExpired = $pelatihan->tanggal_exp_pelatihan && \Carbon\Carbon::parse($pelatihan->tanggal_exp_pelatihan)->isPast();
                    $isFull = ($pelatihan->terisi ?? 0) >= $pelatihan->kuota;
                @endphp

                @if($isExpired)
                    <button class="btn btn-danger w-100 py-3 rounded-3 fw-bold" disabled>Pendaftaran Sudah Expired</button>
                @elseif($isFull)
                    <button class="btn btn-secondary w-100 py-3 rounded-3 fw-bold" disabled>Kuota Penuh</button>
                @else
                    <a href="{{ url('/pelatihan/daftar/' . $pelatihan->id) }}" class="btn btn-daftar w-100 text-center py-3 text-white text-decoration-none d-block">
                        mulai belajar <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection