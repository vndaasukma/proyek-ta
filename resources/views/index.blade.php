@extends('layouts.frontend')

@section('content')
@php
    $banner = \App\Models\Setting::where('key', 'hero_banner')->value('value') ?? 'p4s-hero.jpg';
    $headline = \App\Models\Setting::where('key', 'hero_headline')->value('value') ?? 'inovasi tani hidroponik untuk masa depan.';
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
@endphp

<style>
    /* HERO SECTION */
    .hero-wrapper {
        height: 85vh;
        background: linear-gradient(to right, rgba(25, 135, 84, 0.95) 25%, rgba(0, 0, 0, 0.2)), 
                    url('{{ asset('storage/'.$banner) }}');
        background-size: cover; background-position: center;
        display: flex; align-items: center; color: white;
    }
    .headline-main { font-size: 5.5rem; font-weight: 800; line-height: 1; letter-spacing: -3px; }
    
    /* STATS BOX */
    .stats-container { margin-top: -60px; position: relative; z-index: 10; }
    .stat-card { 
        background: white; border-radius: 20px; padding: 40px; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.08); 
        border-bottom: 6px solid var(--p4s-green);
    }
</style>

<header class="hero-wrapper">
    <div class="container">
        <div class="col-lg-10">
            <h1 class="headline-main mb-4 text-white animate__animated animate__fadeInLeft">
                {{ $headline }}
            </h1>
            <p class="fs-4 mb-5 opacity-80 col-md-9 fw-light text-white">
                mengintegrasikan teknologi hidroponik modern dengan kearifan lokal untuk menciptakan kemandirian pangan desa yang cerdas.
            </p>
            <div class="d-flex gap-3">
                <a href="/pelatihan" class="btn btn-otsuka btn-lg px-5 shadow">daftar pelatihan</a>
                <a href="/kunjungan" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold" style="text-transform: lowercase;">kunjungan</a>
            </div>
        </div>
    </div>
</header>

<div class="container stats-container">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card text-center">
                <i class="fas fa-seedling fa-3x mb-3" style="color: var(--p4s-green)"></i>
                <h4 class="fw-bold">Hidroponik</h4>
                <p class="text-muted small mb-0">Budidaya sayur sehat tanpa tanah dan bebas pestisida.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <i class="fas fa-microchip fa-3x mb-3" style="color: var(--p4s-green)"></i>
                <h4 class="fw-bold">Smart Farming</h4>
                <p class="text-muted small mb-0">Otomasi nutrisi tanaman berbasis teknologi tepat guna.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <i class="fas fa-users fa-3x mb-3" style="color: var(--p4s-green)"></i>
                <h4 class="fw-bold">Edukasi Desa</h4>
                <p class="text-muted small mb-0">Pusat belajar bagi petani muda dan masyarakat umum.</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5 bg-white" style="margin-top: 80px;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-5 mb-md-0">
                <h6 class="text-uppercase fw-bold mb-3" style="color: var(--p4s-green); letter-spacing: 2px; font-size: 0.8rem;">tentang kami</h6>
                <h2 class="display-4 fw-bold mb-4" style="color: #1a1a1a; letter-spacing: -1px;">Membangun Masa Depan Tani dari Desa.</h2>
                <p class="text-muted fs-5 mb-4 fw-light" style="line-height: 1.8;">
                    Kami bukan sekadar kebun, melainkan laboratorium hidup bagi siapa saja yang ingin belajar pertanian masa depan. Dengan metode hidroponik, kita bisa memanen lebih banyak di lahan yang lebih sempit.
                </p>
                <ul class="list-unstyled mb-4 fs-5">
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--p4s-green)"></i> Konsultasi pembuatan instalasi rumah tangga</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--p4s-green)"></i> Pelatihan intensif bersertifikat</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--p4s-green)"></i> Penjualan nutrisi AB Mix & bibit unggul</li>
                </ul>
                <a href="#" class="btn btn-otsuka">pelajari selengkapnya</a>
            </div>
            
            <div class="col-md-6">
                <div class="ps-md-5">
                    <img src="{{ asset('assets/img/p4s-profile.jpg') }}" 
                         class="img-fluid rounded-4 shadow-lg" 
                         alt="Profil P4S Gubuk Sayur" 
                         style="border-left: 15px solid var(--p4s-green);">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection