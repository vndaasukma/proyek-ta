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
        --gs-mid: #142b1c;
        --gs-accent: #4ade80;
        --gs-muted: rgba(255,255,255,0.55);
    }

    * { box-sizing: border-box; }

    /* ── HERO ─────────────────────────────────────────── */
    .hero-partnership {
        background: var(--gs-dark);
        min-height: 92vh;
        display: flex;
        align-items: center;
        color: white;
        position: relative;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }

    /* Layered organic blob background */
    .hero-partnership::before {
        content: '';
        position: absolute;
        width: 800px; height: 800px;
        border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;
        background: radial-gradient(ellipse, rgba(25,135,84,0.18) 0%, transparent 70%);
        top: -200px; right: -200px;
        animation: morphBlob 12s ease-in-out infinite alternate;
    }
    .hero-partnership::after {
        content: '';
        position: absolute;
        width: 500px; height: 500px;
        border-radius: 40% 60% 30% 70% / 60% 40% 60% 40%;
        background: radial-gradient(ellipse, rgba(74,222,128,0.08) 0%, transparent 70%);
        bottom: -100px; left: 10%;
        animation: morphBlob 16s ease-in-out infinite alternate-reverse;
    }
    @keyframes morphBlob {
        0%   { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; transform: scale(1) rotate(0deg); }
        100% { border-radius: 40% 60% 30% 70% / 60% 40% 60% 40%; transform: scale(1.1) rotate(15deg); }
    }

    /* Noise texture overlay */
    .hero-noise {
        position: absolute; inset: 0; z-index: 1;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        background-size: 256px;
        pointer-events: none;
    }

    /* Dot grid */
    .hero-grid {
        position: absolute; inset: 0; z-index: 1;
        background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }

    .hero-content { position: relative; z-index: 10; }

    .hero-tag {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(74,222,128,0.12);
        border: 1px solid rgba(74,222,128,0.3);
        color: var(--gs-accent);
        padding: 6px 16px; border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem; font-weight: 500;
        letter-spacing: 0.08em; text-transform: uppercase;
        margin-bottom: 28px;
    }
    .hero-tag::before {
        content: ''; width: 6px; height: 6px;
        background: var(--gs-accent); border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.8)} }

    .gs-headline {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: clamp(3rem, 6vw, 5.5rem);
        letter-spacing: -0.2px;
        line-height: 0.95;
        color: white;
        margin-bottom: 28px;
    }
    .gs-headline .accent-word {
        color: transparent;
        -webkit-text-stroke: 2px var(--gs-accent);
    }

    .hero-desc {
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem; font-weight: 300;
        color: var(--gs-muted);
        max-width: 600px;
        line-height: 1.75;
        margin-bottom: 48px;
    }

    .btn-gs-primary {
        font-family: 'Inter', sans-serif;
        background: var(--gs-accent);
        color: var(--gs-dark);
        font-weight: 700;
        border-radius: 6px;
        padding: 16px 42px;
        border: none;
        transition: all 0.3s cubic-bezier(.16,1,.3,1);
        font-size: 0.95rem;
        letter-spacing: -0.02em;
        display: inline-flex; align-items: center; gap: 10px;
        text-decoration: none;
    }
    .btn-gs-primary:hover {
        background: white;
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(74,222,128,0.25);
    }
    .btn-gs-primary svg { transition: transform 0.3s; }
    .btn-gs-primary:hover svg { transform: translateX(4px); }

    /* Floating stat cards */
    .hero-stats {
        display: flex; gap: 16px; margin-top: 60px;
    }
    .stat-chip {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 14px 20px;
        backdrop-filter: blur(10px);
    }
    .stat-chip .num {
        font-family: 'Inter', sans-serif;
        font-size: 1.5rem; font-weight: 700;
        color: var(--gs-accent);
        line-height: 1;
    }
    .stat-chip .lbl {
        font-size: 0.72rem; color: var(--gs-muted);
        text-transform: uppercase; letter-spacing: 0.05em;
        margin-top: 4px;
    }

    /* ── JENIS KEMITRAAN ─────────────────────────────── */
    .section-kemitraan {
        background: white;
        padding: 100px 0;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .km-intro-text {
        font-size: 1rem;
        color: #5a7063;
        max-width: 580px;
        line-height: 1.75;
        margin-bottom: 56px;
        font-family: 'Inter', sans-serif;
    }

    .km-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    @media (max-width: 992px) {
        .km-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .km-grid { grid-template-columns: 1fr; }
    }

    .km-card {
        background: #f7f8f5;
        border: 1px solid #e0e9e3;
        border-radius: 16px;
        padding: 32px 28px;
        transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }
    .km-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gs-green), var(--gs-accent));
        opacity: 0;
        transition: opacity 0.3s;
    }
    .km-card:hover {
        border-color: var(--gs-green);
        transform: translateY(-6px);
        box-shadow: 0 16px 48px rgba(25,135,84,0.1);
        background: white;
    }
    .km-card:hover::after { opacity: 1; }

    .km-icon-wrap {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: rgba(25,135,84,0.1);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px;
        font-size: 1.25rem;
    }

    .km-card-badge {
        display: inline-block;
        font-family: 'Inter', sans-serif;
        font-size: 0.68rem; font-weight: 600;
        letter-spacing: 0.08em; text-transform: uppercase;
        color: #0f6e56; background: #d9f2e6;
        border-radius: 4px; padding: 3px 10px;
        margin-bottom: 12px;
    }

    .km-card-title {
        font-family: 'Inter', sans-serif;
        font-size: 1.05rem; font-weight: 700;
        color: var(--gs-dark);
        margin-bottom: 10px; letter-spacing: -0.02em;
    }

    .km-card-desc {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #5a7063;
        line-height: 1.7;
        margin-bottom: 0;
    }

    .km-cta {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 20px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem; font-weight: 600;
        color: var(--gs-green);
        text-decoration: none;
        transition: gap 0.2s;
    }
    .km-cta:hover { gap: 10px; color: var(--gs-green); }
    .km-cta svg { flex-shrink: 0; }


    /* ── TIMELINE ────────────────────────────────────── */
    .section-timeline {
        background: #f7f8f5;
        padding: 120px 0;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }
    .section-timeline::before {
        content: 'proses';
        position: absolute;
        font-family: 'Inter', sans-serif;
        font-size: 20vw; font-weight: 700;
        color: rgba(0,0,0,0.03);
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        white-space: nowrap; pointer-events: none;
        line-height: 1;
    }

    .section-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem; font-weight: 500;
        letter-spacing: 0.15em; text-transform: uppercase;
        color: var(--gs-green);
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 10px;
    }
    .section-label::before {
        content: ''; width: 24px; height: 2px; background: var(--gs-green);
    }

    .gs-title-dark {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: clamp(2.2rem, 4vw, 3.2rem);
        letter-spacing: -0.3px;
        color: var(--gs-dark);
        line-height: 1.05;
        margin-bottom: 72px;
    }

    /* Horizontal stepper */
    .timeline-stepper {
        position: relative;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        counter-reset: step;
    }
    .timeline-stepper::before {
        content: '';
        position: absolute;
        top: 30px; left: 15%; right: 15%;
        height: 1px;
        background: linear-gradient(to right, var(--gs-green), var(--gs-accent));
        z-index: 0;
    }
    .step-item {
        position: relative; z-index: 1;
        display: flex; flex-direction: column; align-items: center;
        text-align: center; padding: 0 16px;
        animation: fadeUp 0.6s ease both;
    }
    .step-item:nth-child(2) { animation-delay: 0.1s; }
    .step-item:nth-child(3) { animation-delay: 0.2s; }
    .step-item:nth-child(4) { animation-delay: 0.3s; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .step-circle {
        width: 60px; height: 60px; border-radius: 50%;
        background: white;
        border: 2px solid #e0e7e3;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1rem;
        color: var(--gs-green);
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s;
        position: relative;
    }
    .step-circle.active {
        background: var(--gs-green);
        color: white;
        border-color: var(--gs-green);
        box-shadow: 0 8px 30px rgba(25,135,84,0.35);
        transform: scale(1.1);
    }
    .step-icon {
        font-size: 1.3rem;
    }
    .step-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.95rem;
        color: var(--gs-dark);
        margin-bottom: 10px;
        letter-spacing: -0.03em;
    }
    .step-desc {
        font-size: 0.83rem;
        color: #6b7c74;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .timeline-stepper {
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        .timeline-stepper::before { display: none; }
    }


    /* ── FORM ────────────────────────────────────────── */
    .section-form {
        background: var(--gs-dark);
        padding: 120px 0;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }
    .section-form::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    .form-card {
        background: #0f2318;
        border: 1px solid rgba(74,222,128,0.15);
        border-radius: 24px;
        padding: 56px 52px;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }
    .form-card::before {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(74,222,128,0.07) 0%, transparent 70%);
        top: -100px; right: -100px;
        pointer-events: none;
    }

    .form-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        letter-spacing: -0.3px;
        color: white;
        line-height: 1.1;
        margin-bottom: 8px;
    }
    .form-subtitle {
        font-size: 0.92rem;
        color: rgba(255,255,255,0.4);
        margin-bottom: 44px;
    }

    .form-group-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        margin-bottom: 8px;
        display: block;
    }

    .gs-input {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 14px 18px;
        color: white;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        transition: all 0.25s;
        outline: none;
        margin-bottom: 24px;
    }
    .gs-input::placeholder { color: rgba(255,255,255,0.2); }
    .gs-input:focus {
        border-color: rgba(74,222,128,0.5);
        background: rgba(74,222,128,0.06);
        box-shadow: 0 0 0 3px rgba(74,222,128,0.08);
    }

    textarea.gs-input { resize: vertical; min-height: 110px; }

    .gs-file-input {
        width: 100%;
        background: rgba(255,255,255,0.03);
        border: 1px dashed rgba(255,255,255,0.15);
        border-radius: 10px;
        padding: 20px 18px;
        color: rgba(255,255,255,0.5);
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        margin-bottom: 6px;
        cursor: pointer;
        transition: all 0.25s;
    }
    .gs-file-input:hover { border-color: rgba(74,222,128,0.4); color: var(--gs-accent); }

    .file-hint {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.25);
        margin-bottom: 32px;
        padding-left: 4px;
    }

    .btn-gs-submit {
        width: 100%;
        background: var(--gs-accent);
        color: var(--gs-dark);
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 17px 32px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(.16,1,.3,1);
        display: flex; align-items: center; justify-content: center; gap: 10px;
        letter-spacing: -0.02em;
    }
    .btn-gs-submit:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 16px 40px rgba(74,222,128,0.2);
    }

    .alert-gs-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 10px;
        color: #fca5a5;
        padding: 14px 20px;
        font-size: 0.9rem;
        margin-bottom: 28px;
    }

    /* Side info panel */
    .info-panel {
        position: sticky; top: 40px;
        color: white;
    }
    .info-panel-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.6rem;
        letter-spacing: -0.3px;
        margin-bottom: 32px;
        line-height: 1.2;
    }
    .info-item {
        display: flex; gap: 16px; align-items: flex-start;
        padding: 20px 0;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .info-item:last-child { border-bottom: none; }
    .info-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: rgba(74,222,128,0.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
        color: var(--gs-accent);
    }
    .info-item-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.9rem;
        color: white; margin-bottom: 4px;
    }
    .info-item-desc {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.4);
        line-height: 1.55;
    }

    /* ── SUCCESS MODAL ───────────────────────────────── */
    .modal-backdrop.show {
        background: rgba(5, 15, 9, 0.88);
        backdrop-filter: blur(8px);
    }

    #successModal .modal-content {
        background: #0a1f13;
        border: 1px solid rgba(74,222,128,0.2);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(74,222,128,0.08);
        font-family: 'Inter', sans-serif;
        color: white;
        position: relative;
    }

    /* Decorative glow blob top-right */
    #successModal .modal-content::before {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(74,222,128,0.09) 0%, transparent 70%);
        top: -80px; right: -80px;
        pointer-events: none;
        z-index: 0;
    }

    /* Dot grid overlay */
    #successModal .modal-content::after {
        content: '';
        position: absolute inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
        border-radius: 24px;
        z-index: 0;
    }

    #successModal .modal-body {
        padding: 52px 44px 44px;
        position: relative; z-index: 2;
        text-align: center;
    }

    .modal-icon-ring {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(74,222,128,0.1);
        border: 1.5px solid rgba(74,222,128,0.3);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 28px;
        position: relative;
        animation: ringPop 0.5s cubic-bezier(.16,1,.3,1) both;
    }
    .modal-icon-ring::after {
        content: '';
        position: absolute; inset: -8px;
        border-radius: 50%;
        border: 1px solid rgba(74,222,128,0.12);
        animation: ringPulse 2.5s ease-in-out 0.5s infinite;
    }
    @keyframes ringPop {
        from { opacity: 0; transform: scale(0.6); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes ringPulse {
        0%,100% { transform: scale(1); opacity: 0.5; }
        50%      { transform: scale(1.18); opacity: 0; }
    }

    .modal-check {
        color: #4ade80;
        animation: checkDraw 0.4s ease 0.2s both;
    }
    @keyframes checkDraw {
        from { opacity: 0; transform: scale(0.5) rotate(-20deg); }
        to   { opacity: 1; transform: scale(1) rotate(0deg); }
    }

    .modal-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(74,222,128,0.1);
        border: 1px solid rgba(74,222,128,0.25);
        color: #4ade80;
        padding: 5px 14px; border-radius: 50px;
        font-size: 0.7rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 20px;
    }
    .modal-badge::before {
        content: ''; width: 5px; height: 5px;
        background: #4ade80; border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    #successModal h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.9rem;
        letter-spacing: -0.4px;
        line-height: 1.05;
        color: white;
        margin-bottom: 14px;
    }

    .modal-divider {
        width: 40px; height: 2px;
        background: linear-gradient(90deg, #4ade80, rgba(74,222,128,0.15));
        border-radius: 2px;
        margin: 18px auto;
    }

    #successModal .modal-msg {
        font-size: 0.875rem;
        color: rgba(255,255,255,0.42);
        line-height: 1.8;
        max-width: 320px;
        margin: 0 auto;
    }

    .modal-meta-row {
        display: flex; gap: 12px; justify-content: center;
        margin: 28px 0 32px;
        flex-wrap: wrap;
    }
    .modal-meta-chip {
        display: flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 12px 18px;
        text-align: left;
        min-width: 148px;
    }
    .modal-meta-chip .chip-icon {
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .modal-meta-chip strong {
        font-weight: 600;
        color: rgba(255,255,255,0.8);
        display: block;
        font-size: 0.78rem;
        letter-spacing: -0.02em;
    }
    .modal-meta-chip span {
        display: block;
        font-size: 0.7rem;
        color: rgba(255,255,255,0.3);
        margin-top: 1px;
    }

    .btn-modal-close {
        width: 100%;
        background: var(--gs-accent);
        color: var(--gs-dark);
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: -0.02em;
        padding: 15px 28px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.3s cubic-bezier(.16,1,.3,1);
    }
    .btn-modal-close:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(74,222,128,0.2);
    }
    .btn-modal-close svg { transition: transform 0.3s; }
    .btn-modal-close:hover svg { transform: translateX(4px); }
</style>

<!-- ═══════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════ -->
<section class="hero-partnership">
    <div class="hero-noise"></div>
    <div class="hero-grid"></div>

    <div class="container hero-content py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-8">
                <div class="hero-tag">Program Kemitraan Strategis</div>
                <h1 class="gs-headline">
                    Kembangkan<br>Potensi<br><span class="accent-word">Pertanian</span><br>Bersama Kami.
                </h1>
                <p class="hero-desc">
                    Kami membuka ruang kolaborasi bagi instansi dan perusahaan untuk memajukan ekosistem pangan lokal yang modern dan berkelanjutan.
                </p>
                <a href="#form-daftar" class="btn-gs-primary">
                    Ajukan Kerjasama
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>

                <div class="hero-stats">
                    <div class="stat-chip">
                        <div class="num">10+</div>
                        <div class="lbl">Mitra Aktif</div>
                    </div>
                    <div class="stat-chip">
                        <div class="num">5 Thn</div>
                        <div class="lbl">Berpengalaman</div>
                    </div>
                    <div class="stat-chip">
                        <div class="num">100%</div>
                        <div class="lbl">Lokal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     JENIS KEMITRAAN
     ═══════════════════════════════════════════════════════ -->
<section class="section-kemitraan">
    <div class="container">
        <div class="section-label">Program Kolaborasi</div>
        <h2 class="gs-title-dark" style="margin-bottom: 16px;">Ruang kolaborasi<br>yang terbuka luas.</h2>
        <p class="km-intro-text">
            P4S Gubuk Sayur membuka berbagai bentuk kemitraan strategis bagi institusi, perusahaan, mahasiswa, maupun individu yang ingin tumbuh bersama dalam ekosistem pertanian modern dan berkelanjutan.
        </p>

        <div class="km-grid">

            <!-- Kerja Sama Lembaga -->
            <div class="km-card">
                <div class="km-icon-wrap">🏛️</div>
                <span class="km-card-badge">Institusional</span>
                <div class="km-card-title">Kerja Sama Lembaga</div>
                <p class="km-card-desc">Kemitraan antar lembaga pemerintah, dinas pertanian, universitas, atau organisasi untuk mendukung pengembangan program ketahanan pangan bersama.</p>
                <a href="#form-daftar" class="km-cta">
                    Ajukan sekarang
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Partnership Bisnis -->
            <div class="km-card">
                <div class="km-icon-wrap">🤝</div>
                <span class="km-card-badge">Bisnis</span>
                <div class="km-card-title">Partnership Bisnis</div>
                <p class="km-card-desc">Kolaborasi dengan perusahaan distribusi, retailer, atau pelaku usaha yang ingin bermitra dalam rantai pasok produk sayuran segar berkualitas langsung dari kebun.</p>
                <a href="#form-daftar" class="km-cta">
                    Ajukan sekarang
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Internship / Magang -->
            <div class="km-card">
                <div class="km-icon-wrap">🎓</div>
                <span class="km-card-badge">Pendidikan</span>
                <div class="km-card-title">Internship / Magang</div>
                <p class="km-card-desc">Program magang bagi mahasiswa dari bidang pertanian, teknologi pangan, bisnis, atau komunikasi. Belajar langsung di lapangan bersama praktisi berpengalaman.</p>
                <a href="#form-daftar" class="km-cta">
                    Ajukan sekarang
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Sponsorship -->
            <div class="km-card">
                <div class="km-icon-wrap">⭐</div>
                <span class="km-card-badge">Sponsorship</span>
                <div class="km-card-title">Sponsorship & Branding</div>
                <p class="km-card-desc">Dukungan branding melalui program CSR atau promosi bersama pada kegiatan panen, edukasi, dan festival pertanian komunitas yang kami selenggarakan.</p>
                <a href="#form-daftar" class="km-cta">
                    Ajukan sekarang
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Riset & Inovasi -->
            <div class="km-card">
                <div class="km-icon-wrap">🔬</div>
                <span class="km-card-badge">Riset</span>
                <div class="km-card-title">Riset & Inovasi</div>
                <p class="km-card-desc">Kolaborasi penelitian bersama perguruan tinggi atau lembaga riset untuk mengembangkan metode budidaya, teknologi tepat guna, dan solusi agrikultur masa depan.</p>
                <a href="#form-daftar" class="km-cta">
                    Ajukan sekarang
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Relawan & Komunitas -->
            <div class="km-card">
                <div class="km-icon-wrap">💚</div>
                <span class="km-card-badge">Komunitas</span>
                <div class="km-card-title">Relawan & Komunitas</div>
                <p class="km-card-desc">Terbuka bagi individu atau komunitas yang ingin terlibat aktif dalam kegiatan edukasi pertanian, pemberdayaan masyarakat, dan program lingkungan hidup.</p>
                <a href="#form-daftar" class="km-cta">
                    Ajukan sekarang
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     TAHAPAN
     ═══════════════════════════════════════════════════════ -->
<section class="section-timeline">
    <div class="container">
        <div class="section-label">Alur Kolaborasi</div>
        <h2 class="gs-title-dark">Tahapan Kemitraan.</h2>

        <div class="timeline-stepper">
            <div class="step-item">
                <div class="step-circle active">
                    <span class="step-icon">📄</span>
                </div>
                <div class="step-title">Pengajuan Dokumen</div>
                <div class="step-desc">Isi formulir dan unggah proposal rencana kerjasama melalui sistem kami.</div>
            </div>
            <div class="step-item">
                <div class="step-circle active">
                    <span class="step-icon">🔍</span>
                </div>
                <div class="step-title">Verifikasi Internal</div>
                <div class="step-desc">Tim manajemen Gubuk Sayur meninjau dokumen yang dikirim.</div>
            </div>
            <div class="step-item">
                <div class="step-circle">
                    <span class="step-icon">🤝</span>
                </div>
                <div class="step-title">Diskusi & Negosiasi</div>
                <div class="step-desc">Pertemuan langsung untuk mematangkan skema kolaborasi yang saling menguntungkan.</div>
            </div>
            <div class="step-item">
                <div class="step-circle">
                    <span class="step-icon">🚀</span>
                </div>
                <div class="step-title">Implementasi</div>
                <div class="step-desc">Penandatanganan MoU dan mulai menjalankan program kemitraan bersama.</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FORM
     ═══════════════════════════════════════════════════════ -->
<section id="form-daftar" class="section-form">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- INFO PANEL -->
            <div class="col-lg-4">
                <div class="info-panel">
                    <p class="section-label" style="color: var(--gs-accent);">Mulai Berkolaborasi</p>
                    <h3 class="info-panel-title">hubungi kami & mulai perjalanan bersama.</h3>

                    <div class="info-item">
                        <div class="info-icon">⏱</div>
                        <div>
                            <div class="info-item-title">Respons Cepat</div>
                            <div class="info-item-desc">Tim kami akan menghubungi dalam 1–2 hari kerja setelah pengajuan diterima.</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">📋</div>
                        <div>
                            <div class="info-item-title">Dokumen Aman</div>
                            <div class="info-item-desc">Proposal dan data yang Anda kirimkan dijaga kerahasiaannya.</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">🌿</div>
                        <div>
                            <div class="info-item-title">Kolaborasi Fleksibel</div>
                            <div class="info-item-desc">Skema kemitraan disesuaikan dengan kebutuhan dan kapasitas masing-masing pihak.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM CARD -->
            <div class="col-lg-8">
                <div class="form-card">
                    <h2 class="form-title">Formulir<br>Kemitraan.</h2>
                    <p class="form-subtitle">silahkan lengkapi data di bawah ini untuk memulai kolaborasi.</p>

                    @if($errors->any())
                        <div class="alert-gs-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kemitraan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-0">
                            <div class="col-md-6 pe-md-2">
                                <label class="form-group-label">Nama Instansi / Perusahaan</label>
                                <input type="text" name="nama_instansi" class="gs-input" placeholder="kelompok tani makmur" required>
                            </div>
                            <div class="col-md-6 ps-md-2">
                                <label class="form-group-label">Nama Perwakilan (PIC)</label>
                                <input type="text" name="nama_perwakilan" class="gs-input" placeholder="nama lengkap anda" required>
                            </div>
                        </div>

                        <label class="form-group-label">Nomor WhatsApp</label>
                        <input type="number" name="no_wa" class="gs-input" placeholder="628123xxxxxxx" required>

                        <!-- KOLOM EMAIL (BARU) -->
                        <label class="form-group-label">Alamat Email Aktif</label>
                        <input type="email" name="email" class="gs-input" placeholder="email@instansi.com" required>

                        <label class="form-group-label">Deskripsi Keperluan</label>
                        <textarea name="deskripsi" class="gs-input" placeholder="jelaskan singkat tujuan kemitraan anda..." required></textarea>

                        <label class="form-group-label">Unggah Proposal (PDF)</label>
                        <input type="file" name="proposal" class="gs-file-input" accept=".pdf">
                        <p class="file-hint">Maksimal file 2MB · Format PDF</p>

                        <button type="submit" class="btn-gs-submit">
                            Kirim Pengajuan sekarang
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     MODAL SUKSES
     ═══════════════════════════════════════════════════════ -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content border-0">
            <div class="modal-body">

                <!-- Icon Ring -->
                <div class="modal-icon-ring">
                    <svg class="modal-check" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <!-- Badge -->
                <div class="modal-badge">Pengajuan Berhasil</div>

                <!-- Headline -->
                <h4>Kemitraan<br>siap diproses.</h4>

                <!-- Divider -->
                <div class="modal-divider"></div>

                <!-- Message -->
                <p class="modal-msg">{{ session('success') }}</p>

                <!-- Meta chips -->
                <div class="modal-meta-row">
                    <div class="modal-meta-chip">
                        <span class="chip-icon">⏱</span>
                        <div>
                            <strong>1–2 Hari Kerja</strong>
                            <span>Estimasi respons</span>
                        </div>
                    </div>
                    <div class="modal-meta-chip">
                        <span class="chip-icon">📲</span>
                        <div>
                            <strong>Via WhatsApp</strong>
                            <span>Tindak lanjut kami</span>
                        </div>
                    </div>
                </div>

                <!-- Close button -->
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                    Mengerti, tutup
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif

@endsection