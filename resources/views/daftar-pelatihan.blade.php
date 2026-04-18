@extends('layouts.frontend')

@section('content')
@php
    /* 1. MENGAMBIL SETTING WARNA */
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';

    /* 2. MENGAMBIL DATA PELATIHAN (Sesuaikan nama model jika bukan KelasPelatihan) */
    $list_pelatihan = \App\Models\KelasPelatihan::where('status', 'tersedia')->get();
@endphp

<style>
    :root { --p4s-green: {{ $themeColor }}; }

    /* HEADER HALAMAN PELATIHAN */
    .header-pelatihan {
        height: 45vh;
        background: linear-gradient(rgba(25, 135, 84, 0.8), rgba(0, 0, 0, 0.6)), 
                    url('{{ asset('assets/img/p4s-hero.jpg') }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        color: white;
    }
    .title-header { font-size: 3.5rem; font-weight: 800; letter-spacing: -2px; text-transform: lowercase; }

    /* CARD STYLE */
    .card-pelatihan { 
        border: none; 
        border-radius: 20px; 
        transition: 0.3s; 
        background: white; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .card-pelatihan:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .img-container { height: 200px; overflow: hidden; border-radius: 20px 20px 0 0; }
    .img-container img { width: 100%; height: 100%; object-fit: cover; }

    /* REVIEW SECTION */
    .review-form { background: white; border-radius: 25px; padding: 40px; border: 2px solid #eee; }
</style>

<section class="header-pelatihan">
    <div class="container text-center text-md-start">
        <div class="col-lg-8">
            <h1 class="title-header mb-3">tingkatkan skill tani anda.</h1>
            <p class="fs-5 fw-light opacity-90">
                pilih program pelatihan hidroponik terbaik kami. belajar langsung dari pakarnya dan jadilah bagian dari revolusi pertanian modern dari desa.
            </p>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2" style="letter-spacing: -1px;">Daftar Kelas Tersedia</h2>
            <div class="mx-auto" style="width: 50px; height: 5px; background: var(--p4s-green)"></div>
        </div>

        <div class="row g-4">
            @forelse($list_pelatihan as $p)
            <div class="col-md-4">
                <div class="card card-pelatihan h-100">
                    <div class="img-container">
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_pelatihan }}">
                    </div>
                    <div class="card-body p-4">
                        <span class="badge rounded-pill px-3 mb-2" style="background: var(--p4s-green)">tersedia</span>
                        <h5 class="fw-bold mb-3">{{ $p->nama_pelatihan }}</h5>
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
                <i class="fas fa-seedling fa-4x mb-3 text-muted"></i>
                <p class="text-muted">Maaf, saat ini belum ada kelas pelatihan yang dibuka.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="review-form shadow-sm">
                    <h3 class="fw-bold mb-4" style="letter-spacing: -1px;">Kirim Review Anda</h3>
                    <form action="/review/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control rounded-pill" placeholder="Contoh: Vinda Permata" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Pilih Pelatihan</label>
                            <select name="kelas" class="form-select rounded-pill">
                                @foreach($list_pelatihan as $p)
                                    <option value="{{ $p->nama_pelatihan }}">{{ $p->nama_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Review Anda</label>
                            <textarea name="komentar" class="form-control" rows="4" style="border-radius: 20px;" placeholder="Apa kesan anda setelah belajar disini?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-otsuka w-100 py-3 shadow">kirim review</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7">
                <h3 class="fw-bold mb-5" style="letter-spacing: -1px;">Review Alumni Pelatihan</h3>
                
                <div class="mb-4 p-4 bg-light rounded-4 border-start border-4" style="border-color: var(--p4s-green) !important;">
                    <p class="fst-italic text-muted">"Materi hidroponiknya sangat aplikatif. Sekarang saya bisa punya kebun sendiri di balkon rumah berkat bimbingan tim P4S Gubuk Sayur!"</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="fw-bold me-2">Suko Widodo</div>
                        <span class="badge bg-dark rounded-pill" style="font-size: 10px;">Alumni 2025</span>
                    </div>
                </div>

                <div class="mb-4 p-4 bg-light rounded-4 border-start border-4" style="border-color: var(--p4s-green) !important;">
                    <p class="fst-italic text-muted">"Tempatnya sangat edukatif, mentornya sabar banget jelasin teknik AB Mix."</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="fw-bold me-2">Dinda Lestari</div>
                        <span class="badge bg-dark rounded-pill" style="font-size: 10px;">Alumni 2026</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection