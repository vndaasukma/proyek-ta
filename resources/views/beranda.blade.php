@extends('layouts.frontend')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #10b981;
        --dark-green: #0f4c3a;
        --text-color: #1e293b;
        --text-muted: #64748b;
        --border: #e2e8f0;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-color);
        /* Warna body dasar kita pasang abu-abu sangat muda */
        background-color: #f8fafc;
    }

    /* ── BLOCK WARNA SEKSUAL (OTSUKA STYLE COLOR BLOCKING) ── */
    .block-white { background-color: #ffffff; }
    .block-mint { background-color: #f0fdf4; } /* Soft Mint Pastel */
    .block-gray { background-color: #f8fafc; } /* Premium Light Gray */
    .section-spacing { padding: 90px 0; position: relative; z-index: 2; }

    /* ── HERO ─────────────────────────────────────────── */
    .hero-slider {
        position: relative;
        min-height: 88vh;
        overflow: hidden;
    }
    .carousel-inner,
    .carousel-item { height: 88vh; }

    .slide-default {
        background: linear-gradient(145deg, #0a2e1f 0%, #0f4c3a 50%, #16a34a 100%);
        height: 100%;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .slide-default::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 60px 60px;
        pointer-events: none;
    }
    .slide-default::after {
        content: '';
        position: absolute;
        width: 700px; height: 700px;
        background: radial-gradient(circle, rgba(16,185,129,0.18) 0%, transparent 65%);
        top: -150px; right: -150px;
        pointer-events: none;
    }

    .slide-image {
        background-size: cover;
        background-position: center;
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
    }
    .slide-image::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(to right, rgba(10,46,31,0.88) 0%, rgba(10,46,31,0.35) 100%);
        z-index: 1;
    }

    .slide-content {
        position: relative;
        z-index: 2;
        color: #fff;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.9);
        padding: 6px 16px;
        border-radius: 4px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 24px;
    }
    .hero-badge::before {
        content: '';
        width: 6px; height: 6px;
        background: #4ade80;
        border-radius: 50%;
        animation: blink 2s ease-in-out infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .hero-slider h1 {
        font-size: clamp(2.4rem, 5.5vw, 4rem);
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 28px;
        color: #ffffff !important;
        letter-spacing: -0.03em;
        text-transform: lowercase;
    }

    .btn-hero-primary {
        background: #fff;
        color: var(--dark-green);
        padding: 13px 32px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-block;
        letter-spacing: -0.01em;
    }
    .btn-hero-primary:hover {
        background: #f0fdf4;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .btn-hero-outline {
        border: 1.5px solid rgba(255,255,255,0.6);
        color: #fff;
        padding: 13px 32px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-block;
        letter-spacing: -0.01em;
    }
    .btn-hero-outline:hover {
        background: rgba(255,255,255,0.1);
        border-color: #fff;
        color: #fff;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 48px; height: 48px;
        top: 50%; transform: translateY(-50%);
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 6px;
        opacity: 1;
        margin: 0 20px;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon { width: 18px; height: 18px; }

    .carousel-indicators { bottom: 24px; }
    .carousel-indicators button {
        width: 24px; height: 3px;
        border-radius: 2px;
        background: rgba(255,255,255,0.4);
        border: none;
    }
    .carousel-indicators button.active { background: #fff; width: 36px; }

    /* ── STATS ── */
    .stats-container {
        margin-top: -56px;
        position: relative;
        z-index: 10;
    }
    .stats-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 28px 24px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }
    .stat-item { text-align: center; padding: 8px 0; }
    .stat-item + .stat-item { border-left: 1px solid var(--border); }
    .stat-num {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-green);
        letter-spacing: -0.04em;
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-label {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* ── SECTION COMMONS ── */
    .section-eyebrow {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--primary-green);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    .section-eyebrow::before {
        content: '';
        width: 20px; height: 2px;
        background: var(--primary-green);
    }

    .section-title {
        font-size: clamp(1.8rem, 3.5vw, 2.5rem);
        font-weight: 700;
        color: var(--dark-green);
        text-transform: lowercase;
        margin-bottom: 0;
        letter-spacing: -0.04em;
        line-height: 1.15;
    }

    /* ── ABOUT ── */
    .about-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .about-feature {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 18px 20px;
    }
    .about-feature h6 {
        font-size: 0.82rem;
        font-weight: 600;
        color: #166534;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 6px;
    }
    .about-feature p {
        font-size: 0.82rem;
        color: #4b7c62;
        line-height: 1.55;
        margin: 0;
    }

    /* ── FASILITAS: FLAT MINIMALIS ── */
    .card-fasilitas {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.25s;
        height: 100%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .card-fasilitas:hover {
        border-color: var(--primary-green);
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(16,185,129,0.08);
    }
    .card-fasilitas .img-wrap {
        width: 100%;
        height: 140px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 14px;
        background: var(--bg-light);
    }
    .card-fasilitas .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .card-fasilitas h5 {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 6px;
        text-transform: lowercase;
    }
    .card-fasilitas p {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0;
    }

    /* ── PROGRAM ── */
    .section-program {
        background: var(--dark-green);
        position: relative;
        overflow: hidden;
    }
    .section-program::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
    }
    .section-program .section-title { color: #fff; }
    .section-program .section-eyebrow { color: #4ade80; }
    .section-program .section-eyebrow::before { background: #4ade80; }

    .card-program {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .card-program:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(74,222,128,0.4);
        transform: translateY(-4px);
    }
    .card-program .img-wrap {
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .card-program .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }
    .card-program:hover .img-wrap img { transform: scale(1.05); }
    .card-program .body {
        padding: 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .card-program h5 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }
    .card-program p {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
        line-height: 1.6;
        flex: 1;
        margin-bottom: 18px;
    }
    .btn-program {
        display: block;
        background: #4ade80;
        color: var(--dark-green);
        text-align: center;
        padding: 11px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.82rem;
        text-decoration: none;
        letter-spacing: -0.01em;
        transition: all 0.2s;
    }
    .btn-program:hover { background: #fff; color: var(--dark-green); }

    /* ── HASIL PANEN ── */
    .produk-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 32px;
    }
    .btn-lihat-semua {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--primary-green);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: -0.01em;
        transition: gap 0.2s;
    }
    .btn-lihat-semua:hover { gap: 10px; color: var(--dark-green); }

    .card-produk {
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.25s;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .card-produk:hover {
        border-color: var(--primary-green);
        box-shadow: 0 10px 25px rgba(16,185,129,0.08);
        transform: translateY(-3px);
    }
    .card-produk .img-wrap {
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .card-produk .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .card-produk .label {
        padding: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-color);
        text-align: center;
        border-top: 1px solid var(--border);
        background: #ffffff;
    }

    /* ── GALERI KEGIATAN ── */
    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .galeri-item {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px;
        transition: all 0.25s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .galeri-item:hover {
        border-color: var(--primary-green);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(16,185,129,0.06);
    }
    .galeri-img-wrap {
        width: 100%;
        height: 160px;
        border-radius: 6px;
        overflow: hidden;
    }
    .galeri-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }
    .galeri-caption {
        margin-top: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-color);
        text-align: center;
        line-height: 1.4;
        text-transform: lowercase;
    }

    @media (max-width: 991px) { .galeri-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .galeri-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .galeri-grid { grid-template-columns: repeat(1, 1fr); } }

    /* ── WA FLOAT ── */
    .wa-float {
        position: fixed;
        bottom: 28px; right: 28px;
        background: #25d366;
        color: white;
        width: 52px; height: 52px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        z-index: 1000;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(37,211,102,0.4);
        transition: all 0.25s;
    }
    .wa-float:hover {
        background: #1da851;
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(37,211,102,0.45);
    }
</style>

<div id="mainHero" class="carousel slide carousel-fade hero-slider" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainHero" data-bs-slide-to="0" class="active"></button>
        @foreach($images->take(5) as $i => $img)
        <button type="button" data-bs-target="#mainHero" data-bs-slide-to="{{ $i + 1 }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="slide-default">
                <div class="container slide-content" data-aos="fade-up" data-aos-duration="700">
                    <div class="hero-badge">P4S Gubuk Sayur Lumajang</div>
                    <h1>{{ \App\Models\Setting::where('key', 'hero_text')->value('value') ?? 'inovasi tani hidroponik untuk masa depan.' }}</h1>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url('/pelatihan') }}" class="btn-hero-primary">daftar pelatihan</a>
                        <a href="{{ url('/kunjungan') }}" class="btn-hero-outline">kunjungan</a>
                    </div>
                </div>
            </div>
        </div>
        @foreach($images->take(5) as $img)
        <div class="carousel-item">
            <div class="slide-image" style="background-image: url('{{ asset('storage/' . $img->image_path) }}');">
                <div class="container slide-content" data-aos="fade-up" data-aos-duration="700">
                    <div class="hero-badge">produk unggulan</div>
                    <h1>{{ $img->title }}</h1>
                    <a href="{{ url('/pelatihan') }}" class="btn-hero-primary">cek detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#mainHero" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainHero" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container stats-container" data-aos="fade-up" data-aos-delay="100">
    <div class="stats-card">
        <div class="stat-item">
            <div class="stat-num">500+</div>
            <div class="stat-label">Alumni Terdidik</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">25+</div>
            <div class="stat-label">Varietas Sayur</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">15+</div>
            <div class="stat-label">Mitra Aktif</div>
        </div>
    </div>
</div>

<section class="section-spacing block-white">
    <div class="container">
        <div class="about-card">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-6 p-5" data-aos="fade-right">
                    <div class="section-eyebrow">Tentang Kami</div>
                    <h2 class="section-title mb-4">mengenal gubuk sayur.</h2>
                    <p class="mb-4" style="font-size:0.95rem;color:var(--text-muted);line-height:1.75;text-transform:lowercase;">
                        kami berfokus pada efisiensi lahan melalui teknologi hidroponik modern untuk menciptakan ekosistem pertanian yang bersih dan cerdas.
                    </p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="about-feature">
                                <h6>Visi Modern</h6>
                                <p>pertanian berbasis data dan sistem nutrisi presisi.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="about-feature">
                                <h6>Edukasi</h6>
                                <p>kurikulum aplikatif bagi siswa dan petani milenial.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" style="min-height:380px;">
                    <img src="{{ asset('assets/img/p4s-asli.png') }}"
                         class="w-100 h-100"
                         alt="Foto P4S Gubuk Sayur"
                         onerror="this.src='{{ asset('asset/img/p4s-asli.png') }}'"
                         style="object-fit:cover; display:block; border-radius: 0 16px 16px 0;">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-spacing block-mint">
    <div class="container">
        <div class="text-center" style="margin-bottom:48px;">
            <div class="section-eyebrow justify-content-center">Infrastruktur</div>
            <h2 class="section-title">fasilitas kami.</h2>
        </div>
        <div class="row g-4">
            @forelse(\App\Models\Fasilitas::all() as $f)
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="card-fasilitas">
                    <div class="img-wrap">
                        <img src="{{ asset('storage/' . $f->gambar) }}"
                             onerror="this.src='https://via.placeholder.com/400x250?text=Fasilitas+P4S'">
                    </div>
                    <h5>{{ $f->nama_fasilitas }}</h5>
                    <p>{{ $f->deskripsi }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:var(--text-muted);font-size:0.88rem;">fasilitas sedang dalam pemeliharaan.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="section-program section-spacing">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 gap-3">
            <div>
                <div class="section-eyebrow">Kelas Tersedia</div>
                <h2 class="section-title">program pilihan.</h2>
            </div>
            <a href="{{ url('/pelatihan') }}" style="color:#4ade80;font-size:0.8rem;font-weight:600;text-decoration:none;letter-spacing:-0.01em;">
                lihat semua →
            </a>
        </div>

        <div class="row g-3 justify-content-center">
            @forelse($list_pelatihan as $p)
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card-program">
                    <div class="img-wrap">
                        <img src="{{ asset('storage/' . $p->gambar) }}"
                             onerror="this.src='https://via.placeholder.com/400x300?text=Pelatihan'"
                             alt="{{ $p->nama_pelatihan }}">
                    </div>
                    <div class="body">
                        <h5>{{ $p->nama_pelatihan }}</h5>
                        <p>{{ Str::limit($p->deskripsi, 80) }}</p>
                        <a href="{{ url('/pelatihan/daftar/'.$p->id) }}" class="btn-program">daftar kelas</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:rgba(255,255,255,0.4);font-size:0.88rem;">program tidak tersedia.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="section-produk section-spacing block-white">
    <div class="container">
        <div class="produk-header">
            <div>
                <div class="section-eyebrow">Produksi</div>
                <h2 class="section-title">hasil panen.</h2>
            </div>
            <a href="#" class="btn-lihat-semua">
                semua produk
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse(\App\Models\Produk::where('type', 'product')->latest()->get() as $img)
            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in">
                <div class="card-produk">
                    <div class="img-wrap">
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->title }}">
                    </div>
                    <div class="label">{{ $img->title }}</div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:var(--text-muted);font-size:0.88rem;padding:40px 0;">belum ada produk.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="section-galeri section-spacing block-gray">
    <div class="container">
        <div class="text-center" style="margin-bottom:40px;">
            <div class="section-eyebrow justify-content-center">Dokumentasi</div>
            <h2 class="section-title">galeri kegiatan.</h2>
        </div>
        <div class="galeri-grid">
            @foreach(\App\Models\Galeri::latest()->take(12)->get() as $g)
            <div class="galeri-item" data-aos="fade-up">
                <div class="galeri-img-wrap">
                    <img src="{{ asset('storage/' . $g->gambar) }}" alt="{{ $g->judul }}">
                </div>
                <div class="galeri-caption">
                    {{ $g->judul ?? 'dokumentasi kegiatan p4s' }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<a href="https://wa.me/6281217214839" class="wa-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({ duration: 550, once: true, offset: 60 });
    });
</script>
@endsection