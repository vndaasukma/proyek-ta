@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --gs-green: {{ $themeColor }};
        --gs-dark: #0a1f13;
        --gs-accent: #4ade80;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }

    .reschedule-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .reschedule-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        overflow: hidden;
        width: 100%;
        max-width: 500px;
        border: 1px solid #eef2f7;
    }

    .card-header-custom {
        background: var(--gs-dark);
        padding: 40px;
        text-align: center;
        color: white;
        position: relative;
    }

    .card-header-custom::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gs-green), var(--gs-accent));
    }

    .card-body-custom {
        padding: 40px;
    }

    .gs-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    .gs-input {
        width: 100%;
        padding: 14px 18px;
        background: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
        margin-bottom: 24px;
        outline: none;
    }

    .gs-input:focus {
        border-color: var(--gs-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
    }

    .btn-submit {
        width: 100%;
        background: var(--gs-green);
        color: white;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit:hover {
        background: var(--gs-dark);
        transform: translateY(-2px);
    }

    .alert-custom {
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        font-size: 0.9rem;
    }
</style>

<div class="reschedule-container">
    <div class="reschedule-card">
        <div class="card-header-custom">
            <h3 class="fw-bold mb-1">Ganti Jadwal</h3>
            <p class="text-white-50 small mb-0">P4S Gubuk Sayur Lumajang</p>
        </div>

        <div class="card-body-custom">
            @if(session('success'))
                <div class="alert alert-success alert-custom border-0 shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-custom border-0 shadow-sm">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pelatihan.request-reschedule') }}" method="POST">
                @csrf

                <div>
                    <label class="gs-label">ID Pendaftaran</label>
                    <input type="text" name="id_pendaftaran" class="gs-input" placeholder="Masukkan ID (Cek di email/WA)" required>
                </div>

                <div>
                    <label class="gs-label">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" class="gs-input" placeholder="Contoh: 628123xxx" required>
                </div>

                <div>
                    <label class="gs-label">Pilih Jadwal Baru</label>
                    <input type="date" name="tgl_baru" class="gs-input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>

                <div>
                    <label class="gs-label">Alasan Perubahan</label>
                    <textarea name="alasan" class="gs-input" rows="3" placeholder="Jelaskan alasan pemindahan jadwal..." required></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    Kirim Permohonan
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="/" class="text-muted small text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection