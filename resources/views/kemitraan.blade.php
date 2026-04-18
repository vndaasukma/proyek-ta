@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
@endphp

<style>
    :root { 
        --gs-green: {{ $themeColor }}; 
        --gs-dark: #0d2b1d; 
    }

    /* =========================================
       HERO SECTION (Identitas Gubuk Sayur)
       ========================================= */
    .hero-partnership {
        background: linear-gradient(135deg, var(--gs-dark) 0%, var(--gs-green) 100%);
        min-height: 85vh;
        display: flex; align-items: center;
        color: white; position: relative; overflow: hidden;
    }
    
    .gs-headline { 
        font-weight: 800; font-size: 5rem; letter-spacing: -2px; line-height: 1; 
        text-transform: lowercase; color: white !important;
    }
    
    .hero-image-gs {
        position: absolute; right: -5%; bottom: -5%; max-height: 100%;
        animation: fadeInUp 1s ease; z-index: 1;
    }

    .btn-gs-primary {
        background: white; color: var(--gs-green); font-weight: 800;
        border-radius: 50px; padding: 15px 45px; border: none; 
        transition: 0.3s; text-transform: lowercase;
    }
    .btn-gs-primary:hover { background: var(--gs-dark); color: white; transform: translateY(-3px); }

    /* =========================================
       ALUR KOLABORASI (Timeline Clean)
       ========================================= */
    .section-timeline { background-color: var(--gs-dark); padding: 100px 0; color: white; position: relative; }
    
    .section-timeline::before {
        content: ''; position: absolute; left: 50%; top: 10%; bottom: 10%;
        width: 2px; background: rgba(255,255,255,0.1); transform: translateX(-50%);
    }

    .gs-title-line { 
        font-weight: 800; text-transform: lowercase; letter-spacing: -1px; 
        color: white !important; display: inline-block; padding-bottom: 10px;
        border-bottom: 5px solid var(--gs-green); margin-bottom: 80px;
    }

    .gs-timeline-item { display: flex; align-items: center; margin-bottom: 60px; position: relative; z-index: 10; }
    .gs-dot {
        width: 18px; height: 18px; border-radius: 50%; background: #444;
        border: 4px solid var(--gs-dark); position: absolute; left: 50%; transform: translateX(-50%);
    }
    .gs-timeline-item.active .gs-dot { background: var(--gs-green); box-shadow: 0 0 15px var(--gs-green); }
    
    .gs-box {
        background: #ffffff; color: #333; border-radius: 25px; padding: 35px;
        width: 42%; position: relative; box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    .gs-timeline-item.left .gs-box { margin-left: auto; margin-right: 55%; }
    .gs-timeline-item.right .gs-box { margin-right: auto; margin-left: 55%; }

    .gs-number { font-weight: 800; font-size: 2.5rem; color: var(--gs-green); line-height: 1; margin-bottom: 10px; }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 992px) {
        .gs-headline { font-size: 3rem; }
        .gs-box { width: 80% !important; margin-left: 60px !important; margin-right: 0 !important; }
        .section-timeline::before, .gs-dot { left: 30px; }
    }
</style>

<section class="hero-partnership">
    <div class="container position-relative" style="z-index: 10;">
        <div class="row">
            <div class="col-lg-8 text-center text-lg-start animate-fadeInUp">
                <h1 class="gs-headline mb-4">kembangkan potensi pertanian bersama kami.</h1>
                <p class="fs-5 fw-light text-white mb-5 opacity-75">
                    kami membuka ruang kolaborasi bagi instansi dan perusahaan untuk memajukan ekosistem pangan lokal yang modern.
                </p>
                <a href="#form-daftar" class="btn btn-gs-primary btn-lg shadow">ajukan kerjasama</a>
            </div>
        </div>
    </div>
    <img src="{{ asset('assets/img/hero-produce-crop.png') }}" class="hero-image-gs d-none d-lg-block">
</section>

<section class="section-timeline">
    <div class="container text-center">
        <h2 class="gs-title-line display-6">tahapan kemitraan.</h2>
        
        <div class="mt-5 text-start">
            <div class="gs-timeline-item left active">
                <div class="gs-dot"></div>
                <div class="gs-box">
                    <div class="gs-number">01</div>
                    <h5 class="fw-bold">Pengajuan Dokumen</h5>
                    <p class="text-muted mb-0">Isi formulir dan unggah proposal rencana kerjasama Anda melalui sistem kami.</p>
                </div>
            </div>

            <div class="gs-timeline-item right active">
                <div class="gs-dot"></div>
                <div class="gs-box">
                    <div class="gs-number">02</div>
                    <h5 class="fw-bold">Verifikasi Internal</h5>
                    <p class="text-muted mb-0">Tim manajemen Gubuk Sayur akan meninjau dokumen untuk kesesuaian visi misi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="form-daftar" class="py-5 bg-white">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-5 border-0 rounded-5 shadow-lg" style="background: #f8f9fa;">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-lowercase" style="letter-spacing: -1.5px;">formulir kemitraan.</h2>
                        <p class="text-muted">silakan lengkapi data di bawah ini untuk memulai kolaborasi.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 text-center mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kemitraan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">NAMA INSTANSI / PERUSAHAAN</label>
                            <input type="text" name="instansi" class="form-control form-control-lg rounded-pill border-0 shadow-sm" placeholder="contoh: kelompok tani makmur" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">NAMA PERWAKILAN (PIC)</label>
                            <input type="text" name="nama" class="form-control form-control-lg rounded-pill border-0 shadow-sm" placeholder="masukkan nama lengkap" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">NOMOR WHATSAPP</label>
                            <input type="number" name="no_wa" class="form-control form-control-lg rounded-pill border-0 shadow-sm" placeholder="628123xxx" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">UNGGAH PROPOSAL (PDF)</label>
                            <input type="file" name="proposal" class="form-control rounded-pill border-0 shadow-sm" accept=".pdf" required style="padding: 12px 25px;">
                            <div class="form-text ms-3">Maksimal file 2MB, format PDF.</div>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 py-3 mt-4 shadow-sm" style="background: var(--gs-green); color: white; border-radius: 50px; font-weight: 700;">
                            kirim pengajuan sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection