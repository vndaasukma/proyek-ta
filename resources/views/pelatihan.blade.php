@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
@endphp

<style>
    :root { --p4s-green: {{ $themeColor }}; --p4s-dark: #0d2b1d; }

    /* HEADER */
    .header-pelatihan {
        height: 45vh;
        background: linear-gradient(rgba(25, 135, 84, 0.85), rgba(13, 43, 29, 0.6)), 
                    url('{{ asset('assets/img/p4s-hero.jpg') }}');
        background-size: cover; background-position: center;
        display: flex; align-items: center; color: white;
    }
    .title-header { font-size: 3.5rem; font-weight: 800; letter-spacing: -2px; text-transform: lowercase; }

    /* CARD STYLE */
    .card-pelatihan { 
        border: none; border-radius: 20px; transition: 0.3s; 
        background: white; box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        height: 100%;
    }
    .card-pelatihan:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .img-container { height: 200px; overflow: hidden; border-radius: 20px 20px 0 0; }
    .img-container img { width: 100%; height: 100%; object-fit: cover; }
</style>

<section class="header-pelatihan">
    <div class="container">
        <div class="col-lg-8">
            <h1 class="title-header mb-3">program pelatihan.</h1>
            <p class="fs-5 fw-light opacity-90">
                tingkatkan keahlian pertanian modern anda bersama mentor berpengalaman di p4s gubuk sayur lumajang.
            </p>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2" style="letter-spacing: -1px; text-transform: lowercase;">daftar kelas tersedia.</h2>
            <div class="mx-auto" style="width: 50px; height: 5px; background: var(--p4s-green)"></div>
        </div>

        <div class="row g-4">
            @forelse($list_pelatihan as $p)
            <div class="col-md-4">
                <div class="card card-pelatihan">
                    <div class="img-container">
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_pelatihan }}">
                        @else
                            <div class="bg-secondary h-100 d-flex align-items-center justify-content-center text-white">no image</div>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <span class="badge rounded-pill px-3 mb-2" style="background: var(--p4s-green)">tersedia</span>
                        <h5 class="fw-bold mb-3 text-lowercase">{{ $p->nama_pelatihan }}</h5>
                        <p class="text-muted small mb-4">{{ Str::limit($p->deskripsi, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="fw-bold fs-5" style="color: var(--p4s-green)">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                            <a href="{{ url('/pelatihan/daftar/'.$p->id) }}" class="btn btn-otsuka btn-sm">mulai belajar</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">saat ini belum ada kelas pelatihan yang dibuka.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection