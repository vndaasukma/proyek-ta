@extends('layouts.frontend')

@section('content')
<style>
    /* HERO MEWAH */
    .hero-glow {
        background: linear-gradient(135deg, #1a4d2e 0%, #2d6a4f 50%, #52b788 100%);
        min-height: 80vh; display: flex; align-items: center; position: relative; overflow: hidden; color: white; border-bottom-right-radius: 120px;
    }
    .hero-glow h1 { font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; text-transform: lowercase; line-height: 1; margin-bottom: 25px; }
    
    .btn-hero-white { background: white; color: #1a4d2e; padding: 15px 40px; border-radius: 50px; font-weight: 800; text-decoration: none; display: inline-block; transition: 0.3s; text-transform: lowercase; }
    .btn-hero-white:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

    .section-spacing { padding: 80px 0; }
    .section-label { font-weight: 800; color: var(--p4s-green); text-transform: lowercase; border-bottom: 4px solid var(--p4s-green); display: inline-block; margin-bottom: 40px; font-size: 2rem; }

    /* CARD STYLE */
    .card-custom { border: none; border-radius: 30px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.05); transition: 0.4s; background: #fff; height: 100%; }
    .card-custom:hover { transform: translateY(-10px); }
    .card-img-wrapper { height: 250px; overflow: hidden; }
    .card-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .card-content { padding: 25px; }
</style>

<div class="hero-glow">
    <div class="container">
        <h1>{{ \App\Models\Setting::where('key', 'hero_text')->value('value') ?? 'inovasi tani hidroponik untuk masa depan.' }}</h1>
        <p class="mb-4">mengintegrasikan teknologi hidroponik modern dengan kearifan lokal.</p>
        <div class="mt-4">
            <a href="{{ url('/pelatihan') }}" class="btn-hero-white">daftar pelatihan</a>
            <a href="{{ url('/kunjungan') }}" class="btn-otsuka ms-lg-3">kunjungan</a>
        </div>
    </div>
</div>

<section class="section-spacing">
    <div class="container">
        <h2 class="section-label">pelatihan terbuka.</h2>
        <div class="row g-4">
            @forelse($list_pelatihan as $p)
            <div class="col-md-4">
                <div class="card-custom">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('storage/' . $p->gambar) }}" onerror="this.src='https://via.placeholder.com/400x250?text=Pelatihan'">
                    </div>
                    <div class="card-content">
                        <h4 class="fw-bold text-lowercase">{{ $p->nama_kelas }}</h4>
                        <p class="text-muted small">{{ Str::limit($p->deskripsi, 100) }}</p>
                        <a href="{{ url('/pelatihan/daftar/'.$p->id) }}" class="btn-otsuka btn-sm w-100">daftar sekarang</a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Belum ada pelatihan yang dibuka.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="section-spacing bg-light">
    <div class="container">
        <h2 class="section-label">produk & kegiatan.</h2>
        <div class="row g-4">
            @forelse($images as $img)
            <div class="col-md-4">
                <div class="card-custom">
                    <div class="card-img-wrapper"><img src="{{ asset($img->image_path) }}"></div>
                    <div class="card-info p-4">
                        <h4 class="fw-bold text-lowercase">{{ $img->title }}</h4>
                        <p class="text-muted small">{{ $img->description }}</p>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Silakan isi foto melalui Admin Portal.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection