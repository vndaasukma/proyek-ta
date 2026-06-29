@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
@endphp

<style>
    :root { 
        --gs-green: {{ $themeColor }}; 
        --gs-dark: #0a1f13; 
        --gs-light: #f8fafc;
    }

    /* --- HERO SECTION --- */
    .contact-hero {
        background: linear-gradient(135deg, var(--gs-dark) 0%, #111 100%);
        padding: 100px 0 160px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: radial-gradient(circle at 70% 30%, rgba(25,135,84,0.15) 0%, transparent 70%);
    }

    .gs-headline { 
        font-weight: 900; font-size: clamp(3rem, 6vw, 5rem); letter-spacing: -3px; 
        line-height: 0.9; text-transform: none;
    }

    /* --- MAIN CONTENT --- */
    .contact-wrapper { margin-top: -100px; position: relative; z-index: 20; padding-bottom: 100px; }

    .main-card {
        background: white;
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 50px 100px rgba(0,0,0,0.08);
        border: 1px solid #f1f5f9;
    }

    /* Left Panel: Info & Map */
    .info-side { background: #f8fafc; padding: 60px; }
    
    .contact-item {
        display: flex; gap: 20px; align-items: flex-start; margin-bottom: 40px;
    }
    
    .icon-box {
        width: 54px; height: 54px; background: white; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        color: var(--gs-green); font-size: 1.4rem; box-shadow: 0 10px 20px rgba(0,0,0,0.03);
        flex-shrink: 0;
    }

    .info-text h6 { font-weight: 800; text-transform: none; margin-bottom: 5px; color: var(--gs-dark); }
    .info-text p { color: #64748b; font-size: 0.95rem; margin-bottom: 0; line-height: 1.6; }

    .mini-map {
        border-radius: 30px; overflow: hidden; border: 8px solid white;
        box-shadow: 0 15px 30px rgba(0,0,0,0.05); margin-top: 20px;
    }

    /* Right Panel: Form */
    .form-side { padding: 60px; }
    
    .form-label-gs {
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1px; color: #94a3b8; margin-bottom: 10px; display: block;
    }

    .input-gs {
        width: 100%; background: #f1f5f9; border: 2px solid transparent;
        border-radius: 18px; padding: 16px 22px; transition: 0.3s;
        font-weight: 500; color: var(--gs-dark);
    }

    .input-gs:focus {
        background: white; border-color: var(--gs-green); outline: none;
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.05);
    }

    .btn-gs-submit {
        background: var(--gs-green); color: white; border: none;
        width: 100%; padding: 20px; border-radius: 20px; font-weight: 900;
        text-transform: none; font-size: 1.1rem; transition: 0.4s;
        box-shadow: 0 20px 40px rgba(25, 135, 84, 0.2);
    }

    .btn-gs-submit:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(25, 135, 84, 0.3); }

    @media (max-width: 992px) {
        .info-side, .form-side { padding: 40px; }
        .gs-headline { font-size: 3.5rem; }
    }
</style>

<section class="contact-hero">
    <div class="container text-center">
        <h1 class="gs-headline mb-4" data-aos="fade-up">Hubungi Kami.</h1>
        <p class="opacity-50 fs-5" data-aos="fade-up" data-aos-delay="100">Kami siap mendengar ide, kritik, dan saran anda.</p>
    </div>
</section>

<div class="container contact-wrapper">
    <div class="main-card" data-aos="zoom-in">
        <div class="row g-0">
            
            <!-- PANEL KIRI: INFORMASI -->
            <div class="col-lg-5 info-side">
                <div class="contact-item">
                    <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-text">
                        <h6> Lokasi Kebun </h6>
                        <p>Dusun krajan, Desa kedawung,<br>Kec. Padang, Lumajang.</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-text">
                        <h6> Kontak Aktif </h6>
                        <p>Whatsapp: +62 812 1721 4839<br>Email: gubuksayur1@gmail.com</p>
                    </div>
                </div>

                <div class="mini-map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15796.86431940902!2d113.206634!3d-8.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwMDcnMjQuNCJTIDExM8KwMTInMjMuOSJF!5e0!3m2!1sid!2sid!4v1711850000000!5m2!1sid!2sid" 
                        width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- PANEL KANAN: FORM -->
            <div class="col-lg-7 form-side">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 p-3 mb-4 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('kontak.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label-gs">nama lengkap</label>
                            <input type="text" name="nama" class="input-gs" placeholder="siapa namamu?" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-gs">nomor whatsapp</label>
                            <input type="text" name="no_hp" class="input-gs" placeholder="0812..." required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-gs">alamat email</label>
                        <input type="email" name="email" class="input-gs" placeholder="sedayu@gmail.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-gs">asal kota</label>
                        <input type="text" name="alamat" class="input-gs" placeholder="contoh: malang / lumajang" required>
                    </div>

                    <div class="mb-5">
                        <label class="form-label-gs">isi pesan</label>
                        <textarea name="pesan" rows="4" class="input-gs" placeholder="tuliskan pesan atau pertanyaan anda disini..." required></textarea>
                    </div>

                    <button type="submit" class="btn-gs-submit">
                        kirim pesan sekarang <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection