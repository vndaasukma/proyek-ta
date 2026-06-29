@extends('layouts.frontend')

@section('content')
<style>
    .article-header {
        padding: 60px 0 40px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .article-category {
        color: #10b981;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .article-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        color: #0f4c3a;
        line-height: 1.2;
    }
    .article-meta {
        font-size: 0.88rem;
        color: #64748b;
    }
    .article-body-wrap {
        padding: 60px 0;
    }
    .article-img-box {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #334155;
        white-space: pre-line;
    }
    .card-rek {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        transition: all 0.2s;
    }
    .card-rek:hover { transform: translateY(-3px); border-color: #10b981; }
</style>

<header class="article-header">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-success text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Artikel Kegiatan</li>
                </ol>
            </nav>
            <span class="article-category d-block mb-2"><i class="fas fa-book-open me-1"></i> Dokumentasi & Berita</span>
            <h1 class="article-title mb-3">{{ $artikel->judul ?? 'Dokumentasi Kegiatan P4S' }}</h1>
            <div class="article-meta d-flex align-items-center gap-3">
                <span><i class="far fa-calendar-alt text-success me-1"></i> {{ $artikel->created_at ? $artikel->created_at->format('d M Y') : date('d M Y') }}</span>
                <span><i class="far fa-user text-success me-1"></i> Admin Gubuk Sayur</span>
            </div>
        </div>
    </div>
</header>

<main class="article-body-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="article-img-box">
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" class="w-100" style="max-height: 500px; object-fit: cover;" alt="{{ $artikel->judul }}">
                </div>

                <div class="article-content mb-5">
                    {{ $artikel->deskripsi ?? 'Belum ada deskripsi detail untuk kegiatan ini.' }}
                </div>

                <hr class="my-5">

                <h4 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.02em;">Dokumentasi Kegiatan Lainnya</h4>
                <div class="row g-4">
                    @foreach($rekomendasi as $rek)
                    <div class="col-md-4">
                        <a href="{{ url('/galeri/'.$rek->id) }}" class="text-decoration-none">
                            <div class="card-rek">
                                <img src="{{ asset('storage/' . $rek->gambar) }}" class="w-100" style="height: 140px; object-fit: cover;" alt="{{ $rek->judul }}">
                                <div class="p-3">
                                    <h6 class="fw-bold text-dark text-truncate mb-1">{{ $rek->judul ?? 'Kegiatan P4S' }}</h6>
                                    <small class="text-muted d-block" style="font-size:0.75rem;">{{ $rek->created_at ? $rek->created_at->format('d M Y') : date('d M Y') }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</main>
@endsection