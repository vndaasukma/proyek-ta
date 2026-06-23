@extends('layouts.frontend')

@section('content')
@php
    /* 1. MENGAMBIL SETTING WARNA */
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';

    /* 2. MENGAMBIL DATA PELATIHAN */
    $list_pelatihan = \App\Models\KelasPelatihan::where('status', 'open')->get();
@endphp

<style>
    :root { --p4s-green: {{ $themeColor }}; }

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

    .card-pelatihan { 
        border: none; 
        border-radius: 20px; 
        transition: 0.3s; 
        background: white; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }
    .card-pelatihan:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .img-container { height: 200px; overflow: hidden; border-radius: 20px 20px 0 0; position: relative; }
    .img-container img { width: 100%; height: 100%; object-fit: cover; }

    .badge-tanggal {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: white;
        color: #333;
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .progress { height: 8px; border-radius: 10px; background-color: #eee; }
    .progress-bar { background-color: var(--p4s-green); border-radius: 10px; }

    .btn-otsuka { background: var(--p4s-green); color: white; border-radius: 50px; font-weight: 700; border: none; transition: 0.3s; }
    .btn-otsuka:hover { background: #000; color: white; transform: scale(1.05); }

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
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_pelatihan }}">
                        @else
                            <img src="{{ asset('assets/img/default-pelatihan.jpg') }}" alt="Default Gambar">
                        @endif
                        <div class="badge-tanggal">
                            <i class="fas fa-calendar-alt text-success me-1"></i>
                            {{ $p->tanggal_pelatihan ? \Carbon\Carbon::parse($p->tanggal_pelatihan)->format('d M Y') : 'Jadwal TBA' }}
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge rounded-pill px-3 mb-2" style="background: var(--p4s-green)">tersedia</span>
                        <h5 class="fw-bold mb-2">{{ $p->nama_pelatihan }}</h5>
                        <p class="text-muted small mb-4">{{ Str::limit($p->deskripsi, 80) }}</p>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-bold text-secondary">Slot Peserta</small>
                                <small class="fw-bold" style="color: var(--p4s-green)">{{ $p->terisi ?? 0 }} / {{ $p->kuota }} Terisi</small>
                            </div>
                            <div class="progress">
                                @php 
                                    $max = $p->kuota > 0 ? $p->kuota : 1;
                                    $persen = (($p->terisi ?? 0) / $max) * 100; 
                                @endphp
                                <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                            <span class="fw-bold fs-5" style="color: var(--p4s-green)">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                            @if(($p->terisi ?? 0) < $p->kuota)
                                <a href="{{ url('/pelatihan/detail/'.$p->id) }}" class="btn text-white px-4 py-2" style="background-color: #0a1f13; border-radius: 8px; font-weight: bold; text-transform: lowercase;">
                                    selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary px-4 py-2" style="border-radius: 8px; font-weight: bold;" disabled>penuh</button>
                            @endif
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