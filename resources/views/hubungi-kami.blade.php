@extends('layouts.frontend')

@section('content')
<style>
    /* --- ANIMASI SMOOTH --- */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade { animation: fadeIn 0.8s ease-out forwards; }

    /* --- HERO DENGAN GRADASI & BLUR --- */
    .contact-hero {
        background: linear-gradient(135deg, #1a4d2e 0%, #2d6a4f 50%, #52b788 100%);
        padding: 120px 0;
        color: white;
        text-align: center;
        border-bottom-right-radius: 150px;
        position: relative;
        overflow: hidden;
    }

    /* Aksesoris Lingkaran Estetik */
    .hero-circle {
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -100px;
        right: -50px;
    }

    .contact-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        letter-spacing: -3px;
        text-transform: lowercase;
        margin-bottom: 20px;
    }

    /* --- CONTENT SECTION --- */
    .contact-body {
        margin-top: -80px; /* Narik konten ke atas hero */
        padding-bottom: 100px;
        background: #fdfdfd;
    }

    /* INFO CARDS - Glassmorphism Style */
    .info-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 40px;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 25px 50px rgba(0,0,0,0.05);
        text-align: center;
        transition: 0.4s;
        height: 100%;
    }

    .info-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(26, 77, 46, 0.1); }

    .icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #1a4d2e, #52b788);
        color: white;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 25px;
        box-shadow: 0 10px 20px rgba(26, 77, 46, 0.2);
    }

    /* FORM CARD - Clean & Elegant */
    .form-wrapper {
        background: white;
        padding: 60px;
        border-radius: 50px;
        box-shadow: 0 30px 70px rgba(0,0,0,0.07);
        border: 1px solid #f0f0f0;
    }

    .form-label {
        font-weight: 700;
        color: #1a4d2e;
        margin-bottom: 12px;
        font-size: 0.9rem;
        text-transform: lowercase;
    }

    .custom-input {
        background: #f8faf9;
        border: 2px solid transparent;
        padding: 16px 25px;
        border-radius: 20px;
        transition: 0.3s;
    }

    .custom-input:focus {
        background: white;
        border-color: #1a4d2e;
        box-shadow: 0 10px 20px rgba(26, 77, 46, 0.05);
        outline: none;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #1a4d2e, #2d6a4f);
        color: white;
        border: none;
        padding: 18px;
        border-radius: 20px;
        font-weight: 800;
        width: 100%;
        text-transform: lowercase;
        letter-spacing: 1px;
        transition: 0.4s;
        margin-top: 20px;
    }

    .btn-gradient:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 30px rgba(26, 77, 46, 0.3);
        color: white;
    }

    /* MAPS SECTION */
    .map-frame {
        margin-top: 80px;
        border-radius: 50px;
        overflow: hidden;
        border: 15px solid white;
        box-shadow: 0 40px 80px rgba(0,0,0,0.1);
    }
</style>

<section class="contact-hero">
    <div class="hero-circle"></div>
    <div class="container animate-fade">
        <h1>say hello.</h1>
        <p>kami senang mendengar masukkan beserta kritik dan saran dari kamu.</p>
    </div>
</section>

<section class="contact-body">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-pill py-3 px-5 mb-5 animate-fade" style="background: #e9f7ef; color: #1a4d2e;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="row g-4 justify-content-center">
            <div class="col-md-4 animate-fade" style="animation-delay: 0.2s;">
                <div class="info-card">
                    <div class="icon-wrapper"><i class="fas fa-map-marked-alt"></i></div>
                    <h4 class="fw-800">lokasi kami.</h4>
                    <p>dusun krajan, desa kedawung, kec. padang, lumajang.</p>
                </div>
            </div>
            <div class="col-md-4 animate-fade" style="animation-delay: 0.4s;">
                <div class="info-card">
                    <div class="icon-wrapper"><i class="fas fa-headset"></i></div>
                    <h4 class="fw-800">kontak aktif.</h4>
                    <p>whatsapp: +62 341 426235<br>email: halo@gubuksayur.com</p>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-10 animate-fade" style="animation-delay: 0.6s;">
                <div class="form-wrapper">
                    <div class="text-center mb-5">
                        <h2 class="fw-800 text-lowercase" style="color: #1a4d2e;">kirim pesan.</h2>
                        <p class="text-muted">Silahkan sampaikan kritik dan saran Anda.</p>
                    </div>

                    <form action="{{ route('kontak.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">nama lengkap</label>
                                <input type="text" name="nama" class="form-control custom-input" placeholder="siapa namamu?" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">nomor hp / wa</label>
                                <input type="text" name="no_hp" class="form-control custom-input" placeholder="08..." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">alamat email</label>
                                <input type="email" name="email" class="form-control custom-input" placeholder="contoh@mail.com" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">asal alamat</label>
                                <input type="text" name="alamat" class="form-control custom-input" placeholder="kota tempat tinggal" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">isi pesan</label>
                            <textarea name="pesan" rows="5" class="form-control custom-input" style="border-radius: 25px;" placeholder="tuliskan sesuatu yang ingin kamu sampaikan..." required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-gradient">
                                <i class="fas fa-paper-plane me-2"></i> kirim pesan sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <div class="map-frame">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15796.86431940902!2d113.206634!3d-8.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwMDcnMjQuNCJTIDExM8KwMTInMjMuOSJF!5e0!3m2!1sid!2sid!4v1711850000000!5m2!1sid!2sid" 
                        width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection