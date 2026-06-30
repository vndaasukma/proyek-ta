@extends('layouts.frontend')

@section('content')
@php
    $profil = \App\Models\ProfilWebsite::first();

    // Gabungkan foto Galeri Kegiatan + foto Hasil Panen (Produk) untuk Background Slider Hero
    $galeri_set = \App\Models\Galeri::latest()->take(6)->get()->map(function ($g) {
        return (object) [
            'gambar'   => $g->gambar,
            'judul'    => $g->judul ?? 'Dokumentasi Kegiatan',
            'kategori' => 'Kegiatan P4S',
        ];
    });

    $panen_set = \App\Models\Produk::where('type', 'product')->latest()->take(6)->get()->map(function ($p) {
        return (object) [
            'gambar'   => $p->image_path,
            'judul'    => $p->title,
            'kategori' => 'Hasil Panen',
        ];
    });

    $galeri_hero = $galeri_set->concat($panen_set)->shuffle()->take(6)->values();
@endphp

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

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
        background-color: #f8fafc;
    }

    .block-white { background-color: #ffffff; }
    .block-mint { background-color: #f0fdf4; }
    .block-gray { background-color: #f8fafc; }
    .section-spacing { padding: 90px 0; position: relative; z-index: 2; }

    /* ── CINEMATIC HERO ────────────────────────── */
    .hero-wrapper {
        position: relative;
        height: 88vh;
        min-height: 600px;
        width: 100%;
        overflow: hidden;
        background-color: var(--dark-green);
    }

    .hero-slider {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }
    .carousel-inner, .carousel-item {
        height: 100%;
        width: 100%;
    }

    .bg-image-overlay {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .bg-image-overlay::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(10, 46, 31, 0.92) 0%, rgba(10, 46, 31, 0.65) 45%, rgba(10, 46, 31, 0.15) 100%);
        z-index: 1;
    }

    .hero-ribbon {
        position: absolute;
        top: 22px;
        right: 22px;
        z-index: 5;
        background: rgba(16,185,129,0.92);
        color: #fff;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        backdrop-filter: blur(4px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }

    .hero-content-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        align-items: center;
        pointer-events: none;
    }
    .hero-content-overlay .container {
        pointer-events: auto;
    }

    .hero-text-box {
        max-width: 650px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .hero-badge::before {
        content: '';
        width: 6px; height: 6px;
        background: #4ade80;
        border-radius: 50%;
        animation: blink 2s ease-in-out infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4.2rem);
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 20px;
        color: #ffffff;
        letter-spacing: -0.02em;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.05rem;
        color: rgba(255,255,255,0.85);
        line-height: 1.6;
        margin-bottom: 35px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .btn-hero-primary {
        background: var(--primary-green);
        color: #fff;
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid var(--primary-green);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    .btn-hero-primary:hover {
        background: #059669;
        border-color: #059669;
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-hero-outline {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.4);
        color: #fff;
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-hero-outline:hover {
        background: #fff;
        color: var(--dark-green);
        transform: translateY(-2px);
    }

    .carousel-indicators { bottom: 30px; justify-content: flex-start; margin-left: auto; margin-right: auto; max-width: 1320px; padding: 0 15px;}
    .carousel-indicators button {
        width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4); border: none; margin: 0 5px; transition: all 0.3s;
    }
    .carousel-indicators button.active { background: #fff; width: 24px; border-radius: 4px; }

    /* ── TICKER / MARQUEE PROMOSI ── */
    .ticker-wrap {
        background: var(--primary-green);
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        z-index: 15;
    }
    .ticker {
        display: inline-flex;
        gap: 50px;
        padding: 10px 0;
        animation: ticker-scroll 22s linear infinite;
    }
    .ticker span {
        color: #fff;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }
    @keyframes ticker-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* ── STATS ── */
    .stats-container {
        margin-top: 40px;
        position: relative;
        z-index: 20;
    }
    .stats-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 28px 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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

    /* ── USP STRIP ── */
    .usp-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 28px;
    }
    .usp-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 18px 20px;
    }
    .usp-icon {
        width: 44px; height: 44px;
        background: #f0fdf4;
        color: var(--primary-green);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .usp-item h6 { font-size: 0.88rem; font-weight: 700; color: var(--text-color); margin-bottom: 2px; }
    .usp-item p { font-size: 0.76rem; color: var(--text-muted); margin: 0; }
    @media (max-width: 768px) { .usp-strip { grid-template-columns: 1fr; } .stats-card { grid-template-columns: repeat(2,1fr); } }

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
        margin-bottom: 0;
        letter-spacing: -0.04em;
        line-height: 1.15;
    }

    /* ── ABOUT - REVAMPED ── */
    .about-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    /* Latar Belakang timeline */
    .latar-timeline {
        list-style: none;
        padding: 0;
        margin: 0 0 28px 0;
    }
    .latar-timeline li {
        display: flex;
        gap: 16px;
        margin-bottom: 18px;
        align-items: flex-start;
    }
    .latar-num {
        min-width: 36px;
        height: 36px;
        background: var(--primary-green);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .latar-timeline li p {
        font-size: 0.875rem;
        color: var(--text-muted);
        line-height: 1.65;
        margin: 0;
    }

    /* Visi & Misi section */
    .visi-misi-wrap {
        background: var(--dark-green);
        border-radius: 0 0 16px 16px;
        padding: 36px 40px;
    }
    .visi-box {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        padding: 20px 24px;
        margin-bottom: 24px;
    }
    .visi-box .eyebrow-sm {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #4ade80;
        margin-bottom: 8px;
    }
    .visi-box p {
        font-size: 0.93rem;
        color: rgba(255,255,255,0.88);
        line-height: 1.65;
        margin: 0;
        font-style: italic;
    }
    .misi-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .misi-list li {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .misi-num {
        min-width: 28px;
        height: 28px;
        background: #4ade80;
        color: var(--dark-green);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 800;
        flex-shrink: 0;
    }
    .misi-list li span {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.75);
        line-height: 1.55;
        padding-top: 4px;
    }
    @media (max-width: 768px) {
        .misi-list { grid-template-columns: 1fr; }
        .visi-misi-wrap { padding: 24px 20px; }
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

    /* ── PENGHARGAAN SECTION ── */
    .section-penghargaan {
        background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }
    .award-table-wrap {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.05);
    }
    .award-table-wrap table {
        width: 100%;
        border-collapse: collapse;
    }
    .award-table-wrap thead tr {
        background: var(--dark-green);
    }
    .award-table-wrap thead th {
        padding: 14px 20px;
        font-size: 0.78rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        text-align: left;
        border: none;
    }
    .award-table-wrap thead th:first-child { width: 52px; text-align: center; }
    .award-table-wrap tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.18s;
    }
    .award-table-wrap tbody tr:last-child { border-bottom: none; }
    .award-table-wrap tbody tr:hover { background: #f0fdf4; }
    .award-table-wrap tbody td {
        padding: 18px 20px;
        font-size: 0.86rem;
        color: var(--text-color);
        line-height: 1.55;
        vertical-align: top;
    }
    .award-table-wrap tbody td:first-child {
        text-align: center;
        font-weight: 700;
        color: var(--primary-green);
        font-size: 1rem;
    }
    .award-title { font-weight: 700; color: var(--dark-green); margin-bottom: 3px; }
    .award-kategori { font-size: 0.77rem; color: var(--text-muted); }
    .award-badge-year {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0fdf4;
        color: var(--dark-green);
        border: 1px solid #bbf7d0;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.76rem;
        font-weight: 700;
    }
    .award-icon-wrap {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    /* ── FASILITAS ── */
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
        background: #f1f5f9;
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

    /* ── PRODUK SEGAR ── */
    .produk-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 32px;
        gap: 20px;
        flex-wrap: wrap;
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
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 10px 18px;
        border-radius: 50px;
        white-space: nowrap;
    }
    .btn-lihat-semua:hover { gap: 10px; color: var(--dark-green); background: #dcfce7; }

    .card-produk-baru {
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: all 0.25s;
        height: 100%;
    }
    .card-produk-baru:hover {
        border-color: var(--primary-green);
        box-shadow: 0 12px 28px rgba(16,185,129,0.1);
        transform: translateY(-4px);
    }
    .card-produk-baru .img-wrap {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .card-produk-baru .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .badge-fresh {
        position: absolute;
        top: 10px; left: 10px;
        z-index: 2;
        background: rgba(16,185,129,0.95);
        color: #fff;
        font-size: 0.66rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .produk-body { padding: 16px; }
    .produk-body h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 6px;
    }
    .produk-body p {
        font-size: 0.78rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 14px;
        min-height: 36px;
    }
    .produk-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .produk-harga {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--dark-green);
    }
    .btn-pesan-wa {
        background: #25d366;
        color: #fff;
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .btn-pesan-wa:hover { background: #1da851; transform: scale(1.08); }

    /* ── GALERI ARTIKEL KEGIATAN ── */
    .card-galeri-baru {
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: all 0.25s;
        height: 100%;
    }
    .card-galeri-baru:hover {
        border-color: var(--primary-green);
        box-shadow: 0 12px 28px rgba(16,185,129,0.1);
        transform: translateY(-4px);
    }
    .card-galeri-baru .img-wrap {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .card-galeri-baru .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }
    .card-galeri-baru:hover .img-wrap img { transform: scale(1.06); }
    .badge-kegiatan {
        position: absolute;
        top: 12px; left: 12px;
        z-index: 2;
        background: rgba(16,185,129,0.95);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .card-galeri-baru .produk-body { padding: 20px; }
    .card-galeri-baru .produk-body h5 { font-size: 1.05rem; color: var(--text-color); }
    .card-galeri-baru .produk-body p { font-size: 0.84rem; min-height: 44px; color: var(--text-muted); }
    .lihat-foto-link {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--primary-green);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

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

{{-- ══════════════════════════════════════════════════ --}}
{{-- HERO                                               --}}
{{-- ══════════════════════════════════════════════════ --}}
<div class="hero-wrapper">
    <div id="heroBackground" class="carousel slide carousel-fade hero-slider" data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="false">
        <div class="carousel-indicators container">
            @foreach($galeri_hero as $i => $img)
                <button type="button" data-bs-target="#heroBackground" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner h-100">
            @forelse($galeri_hero as $index => $g)
            <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">
                <div class="bg-image-overlay" style="background-image: url('{{ asset('storage/' . $g->gambar) }}');">
                    <span class="hero-ribbon">{{ $g->kategori }}</span>
                </div>
            </div>
            @empty
            <div class="carousel-item h-100 active">
                <div class="bg-image-overlay" style="background-image: url('{{ asset('assets/img/p4s-asli.png') }}');"></div>
            </div>
            @endforelse
        </div>
    </div>

    <div class="hero-content-overlay">
        <div class="container">
            <div class="hero-text-box" data-aos="fade-right" data-aos-duration="1000">
                <div class="hero-badge"><i class="fas fa-leaf text-success me-2"></i> P4S Gubuk Sayur Lumajang</div>
                <h1 class="hero-title">{{ \App\Models\Setting::where('key', 'hero_text')->value('value') ?? 'Inovasi Tani Hidroponik untuk Masa Depan' }}</h1>
                <p class="hero-subtitle">Dirintis dari semangat bertani yang berkelanjutan, Gubuk Sayur hadir sebagai pusat pelatihan dan produksi sayuran dan buah hidroponik bebas pestisida — memberdayakan petani milenial Lumajang.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ url('/pelatihan') }}" class="btn-hero-primary">Daftar Pelatihan</a>
                    <a href="https://wa.me/6281217214839" target="_blank" class="btn-hero-outline">Pesan Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TICKER --}}
<div class="ticker-wrap">
    <div class="ticker">
        <span>🥬 Selada Hidroponik Segar</span>
        <span>🍈 Melon Hidroponik Manis</span>
        <span>🌱 100% Organik Tanpa Pestisida</span>
        <span>🏆 10 Besar Lumajang Innovation Award 2023</span>
        <span>📦 Pesan Sekarang via WhatsApp</span>
        <span>🥬 Selada Hidroponik Segar</span>
        <span>🍈 Melon Hidroponik Manis</span>
        <span>🌱 100% Organik Tanpa Pestisida</span>
        <span>🏆 10 Besar Lumajang Innovation Award 2023</span>
        <span>📦 Pesan Sekarang via WhatsApp</span>
    </div>
</div>

{{-- STATS --}}
<div class="container stats-container" data-aos="fade-up" data-aos-delay="100">
    <div class="stats-card">
        <div class="stat-item">
            <div class="stat-num">2021</div>
            <div class="stat-label">Tahun Berdiri</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">500+</div>
            <div class="stat-label">Alumni Terdidik</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">25+</div>
            <div class="stat-label">Varietas Sayur</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">2×</div>
            <div class="stat-label">Penghargaan</div>
        </div>
    </div>

    <div class="usp-strip" data-aos="fade-up" data-aos-delay="150">
        <div class="usp-item">
            <div class="usp-icon"><i class="fas fa-seedling"></i></div>
            <div>
                <h6>100% Organik</h6>
                <p>Tanpa pestisida kimia berbahaya</p>
            </div>
        </div>
        <div class="usp-item">
            <div class="usp-icon"><i class="fas fa-leaf"></i></div>
            <div>
                <h6>Panen Setiap Hari</h6>
                <p>Selada & melon selalu fresh dari kebun</p>
            </div>
        </div>
        <div class="usp-item">
            <div class="usp-icon"><i class="fas fa-truck"></i></div>
            <div>
                <h6>Siap Antar</h6>
                <p>Pesan via WhatsApp, kami kirim ke lokasi Anda</p>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════ --}}
{{-- TENTANG KAMI — Latar Belakang + Visi & Misi       --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="section-spacing block-white">
    <div class="container">
        <div class="about-card">
            <div class="row g-0 align-items-stretch">
                {{-- Kolom kiri: teks Latar Belakang --}}
                <div class="col-lg-6 p-5" data-aos="fade-right">
                    <div class="section-eyebrow">Tentang Kami</div>
                    <h2 class="section-title mb-3">{{ $profil->judul }}</h2>
                    <p style="font-size:0.92rem;color:var(--text-muted);line-height:1.7;margin-bottom:24px;">
                        {{ $profil->deskripsi }}
                    </p>

                    {{-- Latar Belakang Timeline --}}
                    <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--primary-green);margin-bottom:14px;">Latar Belakang</p>
                    <ul class="latar-timeline">
                        <li>
                            <div class="latar-num">01</div>
                            <p>Berawal dari ketertarikan terhadap budidaya sayur secara hidroponik, pemilik usaha <strong>Ahmad Rofi</strong> memulai bisnis ini sejak <strong>Februari 2021</strong> dengan komoditas utama sayur selada hijau.</p>
                        </li>
                        <li>
                            <div class="latar-num">02</div>
                            <p>Teknik hidroponik yang hemat air & tenaga sangat cocok untuk Desa Kedawung yang termasuk <strong>kategori daerah kering</strong> — warga umumnya mengandalkan air hujan dan sumber mata air dari desa/kecamatan lain.</p>
                        </li>
                        <li>
                            <div class="latar-num">03</div>
                            <p>Komoditas pertanian utama desa adalah <strong>tebu, sapi, dan kambing/domba</strong>. Lahan pekarangan warga yang rata-rata cukup luas belum dimanfaatkan secara optimal — peluang inilah yang digarap Gubuk Sayur.</p>
                        </li>
                    </ul>
                </div>

                {{-- Kolom kanan: foto --}}
                <div class="col-lg-6" data-aos="fade-left" style="min-height:380px;">
                    <img src="{{ isset($profil) && $profil->gambar ? asset('storage/' . $profil->gambar) : asset('assets/img/p4s-asli.png') }}"
                         class="w-100 h-100"
                         alt="Foto P4S Gubuk Sayur"
                         onerror="this.src='{{ asset('assets/img/p4s-asli.png') }}'"
                         style="object-fit:cover; display:block; border-radius: 0 16px 0 0;">
                </div>
            </div>

            {{-- Visi & Misi — full width di bawah --}}
            <div class="visi-misi-wrap" data-aos="fade-up">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-4">
                        <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#4ade80;margin-bottom:12px;">{{ $profil->visi_judul }}</p>
                        <div class="visi-box">
                            <p>{{ $profil->visi_deskripsi }}</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#4ade80;margin-bottom:12px;">Misi</p>
                        <ul class="misi-list">
                            <li>
                                <div class="misi-num">01</div>
                                <span>{{ $profil->misi_1 }}</span>
                            </li>
                            <li>
                                <div class="misi-num">02</div>
                                <span>{{ $profil->misi_2 }}</span>
                            </li>
                            <li>
                                <div class="misi-num">03</div>
                                <span>{{ $profil->misi_3 }}</span>
                            </li>
                            <li>
                                <div class="misi-num">04</div>
                                <span>{{ $profil->misi_4 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- PENGHARGAAN                                        --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="section-spacing section-penghargaan">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow justify-content-center">Rekam Jejak</div>
            <h2 class="section-title">Penghargaan yang Telah Diperoleh</h2>
            <p style="font-size:0.92rem;color:var(--text-muted);margin-top:12px;max-width:500px;margin-left:auto;margin-right:auto;">
                Pengakuan dari berbagai pihak atas inovasi dan kontribusi Gubuk Sayur dalam memajukan pertanian milenial di Lumajang.
            </p>
        </div>

        <div class="award-table-wrap" data-aos="fade-up" data-aos-delay="100">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Penghargaan yang Diperoleh</th>
                        <th>Pemberi Penghargaan</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="award-title">10 Besar Lumajang Innovation Award</div>
                            <div class="award-kategori">Kategori: Masyarakat &nbsp;·&nbsp; Bidang Inovasi: Sub Kategori Non Teknologi Informasi dan Non Produk</div>
                        </td>
                        <td>Kepala BAPPEDA Lumajang</td>
                        <td><span class="award-badge-year"><i class="fas fa-trophy"></i> 2023</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <div class="award-title">Pemuda Tani Milenial</div>
                            <div class="award-kategori">Pengakuan atas peran aktif dalam pengembangan pertanian milenial di wilayah Kecamatan Padang</div>
                        </td>
                        <td>Camat Padang</td>
                        <td><span class="award-badge-year"><i class="fas fa-medal"></i> 2023</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- FASILITAS                                          --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="section-spacing block-mint">
    <div class="container">
        <div class="text-center" style="margin-bottom:48px;">
            <div class="section-eyebrow justify-content-center">Infrastruktur</div>
            <h2 class="section-title">Fasilitas Kami</h2>
            <p style="font-size:0.92rem;color:var(--text-muted);margin-top:12px;max-width:480px;margin-left:auto;margin-right:auto;">
                Didukung berbagai fasilitas yang dirancang untuk mendukung proses belajar dan produksi sayuran hidroponik secara optimal.
            </p>
        </div>
        <div class="row g-4">
            @forelse(\App\Models\Fasilitas::all() as $f)
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="card-fasilitas">
                    <div class="img-wrap">
                        <img src="{{ asset('storage/' . $f->gambar) }}" onerror="this.src='https://via.placeholder.com/400x250?text=Fasilitas+P4S'">
                    </div>
                    <h5>{{ $f->nama_fasilitas }}</h5>
                    <p>{{ $f->deskripsi }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:var(--text-muted);font-size:0.88rem;">Fasilitas sedang dalam pemeliharaan.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- PROGRAM PELATIHAN                                  --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="section-program section-spacing">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 gap-3">
            <div>
                <div class="section-eyebrow">Kelas Tersedia</div>
                <h2 class="section-title">Program Pilihan.</h2>
                <p style="font-size:0.88rem;color:rgba(255,255,255,0.5);margin-top:10px;max-width:420px;">
                    Program pelatihan praktis dan aplikatif, dirancang untuk petani pemula hingga yang ingin naik kelas menjadi <em>agripreneur</em> modern.
                </p>
            </div>
            <a href="{{ url('/pelatihan') }}" style="color:#4ade80;font-size:0.8rem;font-weight:600;text-decoration:none;letter-spacing:-0.01em;">
                Lihat Semua →
            </a>
        </div>

        <div class="row g-3 justify-content-center">
            @forelse($list_pelatihan as $p)
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card-program">
                    <div class="img-wrap">
                        <img src="{{ asset('storage/' . $p->gambar) }}" onerror="this.src='https://via.placeholder.com/400x300?text=Pelatihan'" alt="{{ $p->nama_pelatihan }}">
                    </div>
                    <div class="body">
                        <h5>{{ $p->nama_pelatihan }}</h5>
                        <p>{{ Str::limit($p->deskripsi, 80) }}</p>
                        <a href="{{ url('/pelatihan/daftar/'.$p->id) }}" class="btn-program">Daftar Kelas</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:rgba(255,255,255,0.4);font-size:0.88rem;">Program tidak tersedia.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- PRODUK SEGAR                                       --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="section-produk section-spacing block-white">
    <div class="container">
        <div class="produk-header">
            <div>
                <div class="section-eyebrow">Produk P4S</div>
                <h2 class="section-title">Selada & Melon Hidroponik Segar.</h2>
                <p style="font-size:0.92rem;color:var(--text-muted);margin-top:10px;max-width:520px;">
                    Buah dan sayuran berkualitas dibudidayakan dengan sistem hidroponik modern, 
                    menggunakan nutrisi yang terkontrol tanpa penggunaan pestisida, sehingga menghasilkan panen yang sehat, segar, dan berkualitas unggul.
                </p>
            </div>
            <a href="https://wa.me/6281217214839" target="_blank" class="btn-lihat-semua">
                <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
            </a>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse(\App\Models\Produk::where('type', 'product')->latest()->get() as $img)
            @php
                $harga = $img->harga ?? null;
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in">
                <div class="card-produk-baru">
                    <div class="img-wrap">
                        <span class="badge-fresh"><i class="fas fa-leaf"></i> Fresh</span>
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->title }}">
                    </div>
                    <div class="produk-body">
                        <h5>{{ $img->title }}</h5>
                        <p>{{ $img->deskripsi ? Str::limit($img->deskripsi, 75) : '' }}</p>
                        <div class="produk-footer">
                            <span class="produk-harga">{{ $harga ? 'Rp '.number_format($harga,0,',','.') : 'Hubungi Kami' }}</span>
                            <a href="https://wa.me/6281217214839?text={{ urlencode('Halo, saya mau pesan '.$img->title) }}" target="_blank" class="btn-pesan-wa" title="Pesan via WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:var(--text-muted);font-size:0.88rem;padding:40px 0;">Belum ada produk.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- GALERI KEGIATAN & ARTIKEL                          --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="section-galeri section-spacing block-gray">
    <div class="container">
        <div class="text-center" style="margin-bottom:48px;">
            <div class="section-eyebrow justify-content-center">Dokumentasi</div>
            <h2 class="section-title">Galeri Kegiatan & Artikel</h2>
            <p style="font-size:0.92rem;color:var(--text-muted);margin-top:12px;max-width:480px;margin-left:auto;margin-right:auto;">
                Rekam jejak kegiatan pelatihan, kunjungan, dan momen berharga bersama komunitas petani Gubuk Sayur.
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach(\App\Models\Galeri::latest()->take(9)->get() as $g)
            @php
                $deskripsiGaleri = $g->deskripsi ?? 'Momen kegiatan dan aktivitas di P4S Gubuk Sayur Lumajang.';
                $judulGaleri = $g->judul ?? 'Dokumentasi Kegiatan P4S';
            @endphp
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <a href="{{ url('/galeri/' . $g->id) }}" class="text-decoration-none">
                    <div class="card-galeri-baru">
                        <div class="img-wrap">
                            <span class="badge-kegiatan"><i class="fas fa-book-open"></i> Artikel</span>
                            <img src="{{ asset('storage/' . $g->gambar) }}" alt="{{ $judulGaleri }}">
                        </div>
                        <div class="produk-body">
                            <h5>{{ $judulGaleri }}</h5>
                            <p>{{ Str::limit($deskripsiGaleri, 95) }}</p>
                            <div class="produk-footer">
                                <span class="lihat-foto-link"><i class="fas fa-readme"></i> Selengkapnya →</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- WA Float Button --}}
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