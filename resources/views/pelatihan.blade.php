@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
    
    /* AMBIL REVIEW YANG SUDAH DI-ACC ADMIN UNTUK DITAMPILKAN */
    $approved_reviews = \App\Models\Review::where('status', 'approved')->latest()->get();
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --p4s-green: {{ $themeColor }};
        --p4s-dark: #0a1f13;
        --p4s-mid: #0f2318;
        --p4s-accent: #4ade80;
        --p4s-light: #f4f7f5;
    }

    /* ── HEADER ─────────────────────────────────────── */
    .header-pelatihan {
        height: 52vh;
        background: linear-gradient(155deg, rgba(10,31,19,0.92) 0%, rgba(25,135,84,0.7) 100%),
                    url('{{ asset('assets/img/p4s-hero.jpg') }}');
        background-size: cover; background-position: center;
        display: flex; align-items: flex-end;
        color: white; padding-bottom: 60px;
        position: relative; overflow: hidden;
        font-family: 'Inter', sans-serif;
    }
    .header-pelatihan::before {
        content: 'pelatihan';
        position: absolute; bottom: -20px; right: -20px;
        font-family: 'Inter', sans-serif;
        font-size: 18vw; font-weight: 700;
        color: rgba(255,255,255,0.04);
        line-height: 1; pointer-events: none;
        letter-spacing: -0.5px;
    }
    /* Dot grid */
    .header-pelatihan::after {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
        background-size: 36px 36px;
        pointer-events: none;
    }
    .header-inner { position: relative; z-index: 10; }

    .header-tag {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(74,222,128,0.15);
        border: 1px solid rgba(74,222,128,0.3);
        color: var(--p4s-accent);
        padding: 5px 14px; border-radius: 50px;
        font-size: 0.72rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 20px;
    }

    .title-header {
        font-family: 'Inter', sans-serif;
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 700;
        letter-spacing: -0.2px;
        line-height: 0.95;
        margin-bottom: 16px;
        color: white;
    }
    .header-sub {
        font-size: 1rem; font-weight: 300;
        color: rgba(255,255,255,0.6);
        max-width: 500px;
    }


    /* ── KELAS SECTION ──────────────────────────────── */
    .section-kelas {
        background: var(--p4s-light);
        padding: 100px 0;
        font-family: 'Inter', sans-serif;
    }
    .section-eyebrow {
        font-size: 0.72rem; font-weight: 600;
        letter-spacing: 0.15em; text-transform: uppercase;
        color: var(--p4s-green);
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 14px;
    }
    .section-eyebrow::before { content: ''; width: 24px; height: 2px; background: var(--p4s-green); }

    .section-heading {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: clamp(2rem, 4vw, 3rem);
        letter-spacing: -0.3px;
        color: var(--p4s-dark);
        margin-bottom: 56px;
        line-height: 1.1;
    }

    /* Card */
    .card-pelatihan {
        border: none;
        border-radius: 20px;
        background: white;
        overflow: hidden;
        height: 100%;
        transition: all 0.35s cubic-bezier(.16,1,.3,1);
        box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        display: flex; flex-direction: column;
    }
    .card-pelatihan:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    }
    .img-container {
        height: 210px; overflow: hidden; position: relative;
    }
    .img-container img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .card-pelatihan:hover .img-container img { transform: scale(1.06); }
    .img-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(10,31,19,0.4) 0%, transparent 60%);
    }

    .card-body-inner {
        padding: 28px;
        flex: 1; display: flex; flex-direction: column;
    }

    .badge-tersedia {
        display: inline-block;
        background: rgba(74,222,128,0.12);
        color: #16a34a;
        border: 1px solid rgba(74,222,128,0.3);
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 0.7rem; font-weight: 600;
        letter-spacing: 0.08em; text-transform: uppercase;
        margin-bottom: 14px;
    }

    .card-title-pelatihan {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--p4s-dark);
        letter-spacing: -0.04em;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    .card-desc {
        font-size: 0.85rem;
        color: #6b7c74;
        line-height: 1.65;
        flex: 1;
        margin-bottom: 24px;
    }
    .card-footer-inner {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 20px;
        border-top: 1px solid #f0f4f2;
    }
    .card-price {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.3rem;
        color: var(--p4s-green);
        letter-spacing: -0.05em;
    }
    .btn-mulai {
        background: var(--p4s-dark);
        color: white;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-mulai:hover { background: var(--p4s-green); color: white; transform: translateX(3px); }

    .empty-state {
        text-align: center; padding: 80px 0;
        color: #a0b0a8;
        font-style: italic;
    }

    /* ── REVIEW SECTION ─────────────────────────────── */
    .section-review {
        background: var(--p4s-dark);
        padding: 120px 0;
        font-family: 'Inter', sans-serif;
        position: relative; overflow: hidden;
    }
    .section-review::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    /* Form panel */
    .review-form-panel {
        background: #0f2318;
        border: 1px solid rgba(74,222,128,0.15);
        border-radius: 20px;
        padding: 40px;
        position: relative; z-index: 1;
    }
    .review-form-panel::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(74,222,128,0.07) 0%, transparent 70%);
        top: -80px; right: -80px; pointer-events: none;
    }

    .review-panel-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1.6rem;
        letter-spacing: -0.2px;
        color: white; margin-bottom: 6px;
    }
    .review-panel-sub {
        font-size: 0.83rem; color: rgba(255,255,255,0.35);
        margin-bottom: 32px;
    }

    .rv-label {
        font-size: 0.7rem; font-weight: 600;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: rgba(255,255,255,0.35); margin-bottom: 8px; display: block;
    }
    .rv-input {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 13px 16px;
        color: white;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        margin-bottom: 20px;
        transition: all 0.25s; outline: none;
    }
    .rv-input::placeholder { color: rgba(255,255,255,0.18); }
    .rv-input:focus {
        border-color: rgba(74,222,128,0.45);
        background: rgba(74,222,128,0.05);
        box-shadow: 0 0 0 3px rgba(74,222,128,0.08);
    }
    select.rv-input option { background: #0f2318; color: white; }
    textarea.rv-input { resize: vertical; min-height: 100px; }

    .btn-kirim-rv {
        width: 100%;
        background: var(--p4s-accent);
        color: var(--p4s-dark);
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.9rem;
        padding: 15px;
        border: none; border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(.16,1,.3,1);
    }
    .btn-kirim-rv:hover { background: white; transform: translateY(-3px); box-shadow: 0 12px 30px rgba(74,222,128,0.2); }

    /* Review list */
    .reviews-side {
        position: relative; z-index: 1;
    }
    .reviews-heading {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        letter-spacing: -0.2px;
        color: white;
        margin-bottom: 36px;
        line-height: 1.15;
    }

    .review-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 16px;
        transition: all 0.25s;
        position: relative;
        overflow: hidden;
    }
    .review-card::before {
        content: '"';
        position: absolute; top: -10px; left: 20px;
        font-family: 'Inter', sans-serif;
        font-size: 5rem; font-weight: 700;
        color: rgba(74,222,128,0.08);
        line-height: 1;
    }
    .review-card:hover {
        background: rgba(74,222,128,0.06);
        border-color: rgba(74,222,128,0.2);
        transform: translateX(4px);
    }
    .review-text {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.65);
        line-height: 1.7;
        font-style: italic;
        margin-bottom: 20px;
        position: relative; z-index: 1;
    }
    .review-author {
        display: flex; align-items: center; gap: 12px;
        position: relative; z-index: 1;
    }
    .author-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, var(--p4s-green), var(--p4s-accent));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.85rem;
        color: white; flex-shrink: 0;
    }
    .author-name {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.88rem;
        color: white;
    }
    .author-class {
        font-size: 0.72rem; color: rgba(255,255,255,0.35);
        margin-top: 2px;
    }

    .empty-review {
        text-align: center; padding: 60px 20px;
        color: rgba(255,255,255,0.25);
        font-style: italic; font-size: 0.88rem;
    }

    /* Alert success */
    .alert-success-dark {
        background: rgba(74,222,128,0.1);
        border: 1px solid rgba(74,222,128,0.3);
        border-radius: 10px;
        color: var(--p4s-accent);
        padding: 12px 18px;
        font-size: 0.87rem;
        margin-bottom: 24px;
    }
</style>

<!-- Alert global -->
@if(session('success'))
<div style="position:fixed;top:80px;right:24px;z-index:9999;background:rgba(74,222,128,0.15);border:1px solid rgba(74,222,128,0.35);border-radius:10px;padding:14px 22px;color:#4ade80;font-family:'Inter',sans-serif;font-size:0.88rem;backdrop-filter:blur(10px);box-shadow:0 8px 30px rgba(0,0,0,0.2);">
    ✓ {{ session('success') }}
</div>
@endif


<!-- ═══════════════════════════════════════════════════════
     HEADER
     ═══════════════════════════════════════════════════════ -->
<section class="header-pelatihan">
    <div class="container header-inner">
        <div class="header-tag">P4S Gubuk Sayur Lumajang</div>
        <h1 class="title-header">program<br>pelatihan.</h1>
        <p class="header-sub">tingkatkan keahlian pertanian modern anda bersama mentor berpengalaman.</p>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════
     DAFTAR KELAS
     ═══════════════════════════════════════════════════════ -->
<section class="section-kelas">
    <div class="container">
        <div class="section-eyebrow">Kelas Tersedia</div>
        <h2 class="section-heading">pilih program belajar anda.</h2>

        <div class="row g-4">
            @forelse($list_pelatihan as $p)
            <div class="col-md-4">
                <div class="card-pelatihan">
                    <div class="img-container">
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_pelatihan }}">
                        @else
                            <div style="background:linear-gradient(135deg,#0a1f13,#198754);height:100%;display:flex;align-items:center;justify-content:center;">
                                <span style="font-size:3rem;">🌿</span>
                            </div>
                        @endif
                        <div class="img-overlay"></div>
                    </div>
                    <div class="card-body-inner">
                        <span class="badge-tersedia">tersedia</span>
                        <h5 class="card-title-pelatihan">{{ $p->nama_pelatihan }}</h5>
                        <p class="card-desc">{{ Str::limit($p->deskripsi, 110) }}</p>
                        <div class="card-footer-inner">
                            <span class="card-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                            
                            <!-- DIPERBAIKI: Mengarah ke route detail-pelatihan dan teks diubah menjadi 'selengkapnya' -->
                            <a href="{{ url('/pelatihan/detail/'.$p->id) }}" class="btn-mulai">
                                selengkapnya
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">saat ini belum ada kelas pelatihan yang dibuka.</div>
            </div>
            @endforelse
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════
     REVIEW
     ═══════════════════════════════════════════════════════ -->
<section class="section-review">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- FORM REVIEW -->
            <div class="col-lg-5">
                <div class="review-form-panel">
                    <p class="section-eyebrow" style="color:var(--p4s-accent);">Bagikan Pengalaman</p>
                    <h3 class="review-panel-title">kirim review anda.</h3>
                    <p class="review-panel-sub">ceritakan kesan belajar di P4S Gubuk Sayur.</p>

                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <label class="rv-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="rv-input" placeholder="siapa nama anda?" required>

                        <label class="rv-label">Program Pelatihan</label>
                        <select name="pelatihan" class="rv-input">
                            @foreach($list_pelatihan as $lp)
                                <option value="{{ $lp->nama_pelatihan }}">{{ $lp->nama_pelatihan }}</option>
                            </select>
                            @endforeach
                        </select>

                        <label class="rv-label">Review / Kesan</label>
                        <textarea name="komentar" class="rv-input" placeholder="ceritakan pengalaman belajar anda..." required></textarea>

                        <button type="submit" class="btn-kirim-rv">kirim review</button>
                    </form>
                </div>
            </div>

            <!-- LIST REVIEW -->
            <div class="col-lg-7">
                <div class="reviews-side">
                    <p class="section-eyebrow" style="color:var(--p4s-accent);">Testimoni Alumni</p>
                    <h3 class="reviews-heading">apa kata<br>mereka.</h3>

                    @forelse($approved_reviews as $rev)
                    <div class="review-card">
                        <p class="review-text">"{{ $rev->komentar }}"</p>
                        <div class="review-author">
                            <div class="author-avatar">{{ strtoupper(substr($rev->nama, 0, 1)) }}</div>
                            <div>
                                <div class="author-name">{{ $rev->nama }}</div>
                                <div class="author-class">{{ $rev->pelatihan }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-review">belum ada review yang disetujui admin.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>
@endsection