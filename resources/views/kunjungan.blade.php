@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
    
    // Logika Kalender Dinamis
    $startOfMonth = $carbonDate->copy()->startOfMonth();
    $blankDays = $startOfMonth->dayOfWeek;
    $daysInMonth = $carbonDate->daysInMonth;
    $today = date('Y-m-d');
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --p4s-green: {{ $themeColor }};
        --p4s-dark: #0a1f13;
        --p4s-mid: #0f2318;
        --p4s-accent: #4ade80;
        --p4s-muted: rgba(255,255,255,0.45);
    }

    /* ── HEADER ─────────────────────────────────────── */
    .header-kunjungan {
        height: 48vh;
        background: linear-gradient(155deg, rgba(10,31,19,0.9) 0%, rgba(25,135,84,0.65) 100%),
                    url('{{ asset('assets/img/p4s-hero.jpg') }}');
        background-size: cover; background-position: center;
        display: flex; align-items: flex-end;
        color: white; padding-bottom: 0;
        position: relative; overflow: hidden;
        font-family: 'Inter', sans-serif;
    }
    .header-kunjungan::after {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 36px 36px; pointer-events: none;
    }
    .header-inner-kj {
        position: relative; z-index: 10;
        padding: 0 0 0 0;
        width: 100%;
    }

    /* Swooping white card lift */
    .header-card-lift {
        background: #f4f7f5;
        border-radius: 28px 28px 0 0;
        padding: 40px 40px 0 40px;
        margin-top: 40px;
    }

    .header-eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(74,222,128,0.15);
        border: 1px solid rgba(74,222,128,0.3);
        color: var(--p4s-accent);
        padding: 5px 14px; border-radius: 50px;
        font-size: 0.7rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 18px;
    }
    .header-title-kj {
        font-family: 'Inter', sans-serif;
        font-size: clamp(2.5rem, 6vw, 4.8rem);
        font-weight: 700; letter-spacing: -0.3px;
        line-height: 0.92; color: white;
        margin-bottom: 14px;
        text-transform: none;
    }
    .header-sub-kj {
        font-size: 0.95rem; font-weight: 300;
        color: rgba(255,255,255,0.55);
        max-width: 420px;
    }


    /* ── MAIN LAYOUT ─────────────────────────────────── */
    .kunjungan-main {
        background: #f4f7f5;
        padding-bottom: 100px;
        font-family: 'Inter', sans-serif;
    }

    /* ── CALENDAR ─────────────────────────────────────── */
    .calendar-container {
        background: var(--p4s-dark);
        border-radius: 24px;
        padding: 36px;
        color: white;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        position: relative; overflow: hidden;
    }
    .calendar-container::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 28px 28px; pointer-events: none;
    }
    .calendar-container::after {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(74,222,128,0.08) 0%, transparent 65%);
        top: -100px; right: -100px; pointer-events: none;
    }

    .calendar-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 28px;
        position: relative; z-index: 5;
    }
    .cal-month-label {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1.4rem;
        letter-spacing: -0.3px; text-transform: capitalize;
    }
    .cal-nav {
        display: flex; gap: 8px;
    }
    .cal-nav a {
        width: 36px; height: 36px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.15);
        color: white; text-decoration: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    .cal-nav a:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.3); }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
        text-align: center;
        position: relative; z-index: 5;
    }
    .day-name {
        font-weight: 600; opacity: 0.35;
        padding-bottom: 12px; font-size: 0.72rem;
        text-transform: uppercase; letter-spacing: 0.05em;
    }

    .date-item {
        padding: 12px 4px; border-radius: 10px;
        cursor: pointer; transition: all 0.2s;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        text-decoration: none; color: white;
        font-size: 0.9rem;
    }
    .date-item:hover:not(.disabled) {
        background: rgba(255,255,255,0.1);
        color: white;
    }
    .date-item.active {
        background: var(--p4s-green) !important;
        box-shadow: 0 4px 20px rgba(25,135,84,0.4);
        color: white;
    }
    .date-item.disabled { opacity: 0.2; cursor: not-allowed; }

    .dots { display: flex; gap: 3px; margin-top: 5px; }
    .dot { width: 5px; height: 5px; border-radius: 50%; }
    .dot.available { background: var(--p4s-accent); }
    .dot.booked { background: #f87171; }

    /* ── SESSION SECTION ──────────────────────────────── */
    .session-section {
        padding-top: 0;
    }
    .session-date-badge {
        display: inline-block;
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.85rem;
        letter-spacing: -0.02em;
        color: var(--p4s-dark);
        background: white;
        border: 1px solid #e0e7e3;
        padding: 8px 22px; border-radius: 50px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .session-date-badge span {
        color: var(--p4s-green);
    }

    /* Session card */
    .session-card {
        background: var(--p4s-dark);
        color: white; border-radius: 16px;
        padding: 20px 22px;
        display: flex; flex-direction: row;
        align-items: center; gap: 16px;
        transition: all 0.3s cubic-bezier(.16,1,.3,1);
        position: relative; overflow: hidden;
        border-left: 4px solid var(--p4s-green);
    }
    .session-card::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse at top right, rgba(74,222,128,0.07) 0%, transparent 60%);
        pointer-events: none;
    }
    .session-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
    .session-card.full { border-left-color: #374151; }
    .session-card.full::before { display: none; }

    .sesi-info { flex: 1; min-width: 0; }

    .sesi-num {
        font-size: 0.65rem; font-weight: 600;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: rgba(255,255,255,0.35);
        margin-bottom: 4px;
    }
    .sesi-jam {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1.5rem;
        letter-spacing: -0.3px; color: white;
        line-height: 1;
    }
    .sesi-status-text {
        font-size: 0.72rem; color: rgba(255,255,255,0.35);
        margin-top: 4px;
    }
    .sesi-booked-name {
        font-size: 0.72rem; color: rgba(255,255,255,0.4);
        margin-top: 4px; font-style: italic;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .sesi-tag-lewat {
        font-size: 0.72rem; color: #f87171;
        margin-top: 4px;
    }

    .sesi-action { flex-shrink: 0; }

    .btn-sesi-pilih {
        background: var(--p4s-accent);
        color: var(--p4s-dark);
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.78rem;
        padding: 10px 16px; border: none;
        border-radius: 8px; cursor: pointer;
        transition: all 0.25s;
        display: flex; align-items: center; gap: 6px;
        white-space: nowrap;
    }
    .btn-sesi-pilih:hover { background: white; transform: scale(1.02); }
    .btn-sesi-disabled {
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.25);
        font-family: 'Inter', sans-serif;
        font-weight: 600; font-size: 0.75rem;
        padding: 10px 14px; border: none;
        border-radius: 8px; cursor: not-allowed;
        white-space: nowrap;
    }


    /* ── MODAL ─────────────────────────────────────────── */
    #bookingModal .modal-content {
        background: var(--p4s-dark);
        border: 1px solid rgba(74,222,128,0.2);
        border-radius: 24px;
        color: white;
        font-family: 'Inter', sans-serif;
        position: relative; overflow: hidden;
    }
    #bookingModal .modal-content::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(74,222,128,0.07) 0%, transparent 70%);
        top: -80px; right: -80px; pointer-events: none;
    }
    .modal-header-custom {
        padding: 28px 32px 0;
        display: flex; justify-content: space-between; align-items: center;
        position: relative; z-index: 1;
    }
    .modal-title-custom {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1.3rem;
        letter-spacing: -0.3px; color: white;
    }
    .modal-close-btn {
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(255,255,255,0.08);
        border: none; color: white; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem; transition: background 0.2s;
    }
    .modal-close-btn:hover { background: rgba(255,255,255,0.15); }

    .modal-body-custom {
        padding: 24px 32px 32px;
        position: relative; z-index: 1;
    }

    .modal-label {
        font-size: 0.68rem; font-weight: 600;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: rgba(255,255,255,0.35); margin-bottom: 8px; display: block;
    }
    .modal-input {
        width: 100%;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 13px 16px; color: white;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem; outline: none;
        margin-bottom: 18px; transition: all 0.25s;
    }
    .modal-input::placeholder { color: rgba(255,255,255,0.2); }
    .modal-input:focus {
        border-color: rgba(74,222,128,0.45);
        background: rgba(74,222,128,0.05);
        box-shadow: 0 0 0 3px rgba(74,222,128,0.08);
    }
    textarea.modal-input { resize: vertical; min-height: 90px; }

    .btn-modal-submit {
        width: 100%;
        background: var(--p4s-accent);
        color: var(--p4s-dark);
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.9rem;
        padding: 15px; border: none; border-radius: 10px;
        cursor: pointer; margin-top: 8px;
        transition: all 0.3s cubic-bezier(.16,1,.3,1);
    }
    .btn-modal-submit:hover { background: white; transform: translateY(-3px); box-shadow: 0 12px 30px rgba(74,222,128,0.2); }

    /* ── FLOATING SUCCESS ALERT (TOAST) BERCERITA ─────────────────────────── */
    @keyframes slideDownToast {
        0% { transform: translate(-50%, -100%); opacity: 0; }
        100% { transform: translate(-50%, 20px); opacity: 1; }
    }

    .toast-success-kj {
        position: fixed;
        top: 0; left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        width: 90%; max-width: 500px;
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        border-left: 8px solid var(--p4s-green);
        display: flex; gap: 15px; align-items: flex-start;
        animation: slideDownToast 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .toast-icon {
        width: 45px; height: 45px;
        background: rgba(25, 135, 84, 0.1);
        color: var(--p4s-green);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }

    .tindak-lanjut-box {
        background: #f8fafc;
        border-left: 3px solid #cbd5e1;
        padding: 10px 12px;
        border-radius: 6px;
        margin-top: 12px;
    }

    .alert-kj-error {
        background: rgba(248,113,113,0.1);
        border: 1px solid rgba(248,113,113,0.3);
        border-radius: 10px; color: #f87171;
        padding: 12px 16px; font-size: 0.85rem;
        margin-bottom: 20px;
    }
</style>


<section class="header-kunjungan">
    <div class="container header-inner-kj">
        <div class="row">
            <div class="col-lg-7 text-white pb-5">
                <div class="header-eyebrow">P4S Gubuk Sayur</div>
                <h1 class="header-title-kj">Kunjungan<br>Edukatif</h1>
                <p class="header-sub-kj">Pilih tanggal kunjungan untuk reservasi sesi bersama kami.</p>
            </div>
        </div>
    </div>
</section>

@if(session('success'))
    <div class="toast-success-kj" id="successToast">
        <div class="toast-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div style="flex:1;">
            <h5 style="margin: 0 0 5px 0; font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.05rem; color: #0a1f13; letter-spacing: -0.5px;">Reservasi Sedang Ditinjau</h5>
            <p style="margin: 0; font-size: 0.85rem; color: #475569; line-height: 1.4;">{{ session('success') }}</p>
            
            <div class="tindak-lanjut-box">
                <span style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 3px;">Tindak Lanjut:</span>
                <span style="font-size: 0.8rem; color: #334155; line-height: 1.3;">Pastikan nomor WhatsApp yang Anda daftarkan aktif untuk menerima pesan konfirmasi dari admin kami.</span>
            </div>
        </div>
        <button type="button" onclick="this.closest('.toast-success-kj').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.5rem; cursor:pointer; padding:0; line-height:1;">&times;</button>
    </div>
    
    <script>
        setTimeout(() => {
            const toast = document.getElementById('successToast');
            if(toast) {
                toast.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -150%)';
                setTimeout(() => toast.style.display = 'none', 600);
            }
        }, 12000); 
    </script>
@endif


<div class="kunjungan-main">
    <div class="container pt-5">

        @if($errors->any())
            <div class="alert-kj-error">
                <ul class="mb-0" style="padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li style="font-size:0.83rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-5">

            <div class="col-lg-7">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <span class="cal-month-label">{{ $carbonDate->translatedFormat('F Y') }}</span>
                        <div class="cal-nav">
                            <a href="?date={{ $carbonDate->copy()->subMonth()->format('Y-m-d') }}">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                            <a href="?date={{ $carbonDate->copy()->addMonth()->format('Y-m-d') }}">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="calendar-grid">
                        @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dayName)
                            <div class="day-name">{{ $dayName }}</div>
                        @endforeach

                        @for($i = 0; $i < $blankDays; $i++)
                            <div></div>
                        @endfor

                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $currentDate = $carbonDate->copy()->day($day)->format('Y-m-d');
                                $active = $currentDate == $tanggalDipilih ? 'active' : '';
                                $bookedCount = $allBookings->has($currentDate) ? count($allBookings[$currentDate]) : 0;
                                
                                // 🔒 LOGIKA BARU: Cek apakah tanggal saat ini sedang digembok/dikunci oleh admin
                                $isLockedByAdmin = in_array($currentDate, $lockedDates ?? []);
                                $isDisabled = $currentDate < $today || $isLockedByAdmin;
                            @endphp
                            <a href="{{ $isDisabled ? '#' : '?date=' . $currentDate }}" 
                               class="date-item {{ $active }} {{ $isDisabled ? 'disabled' : '' }}">
                                <span>{{ $day }}</span>
                                <div class="dots">
                                    @for($s = 1; $s <= 3; $s++)
                                        <div class="dot {{ ($s <= $bookedCount || $isLockedByAdmin) ? 'booked' : 'available' }}"></div>
                                    @endfor
                                </div>
                            </a>
                        @endfor
                    </div>
                </div>

                <div class="d-flex gap-4 mt-3 ps-1">
                    <div class="d-flex align-items-center gap-2" style="font-size:0.78rem;color:#6b7c74;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#4ade80;display:inline-block;"></span>
                        Slot tersedia
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size:0.78rem;color:#6b7c74;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#f87171;display:inline-block;"></span>
                        Terisi / Ditutup
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="session-section">
                    <p style="font-size:0.75rem;color:#6b7c74;margin-bottom:8px;font-family:'Inter',sans-serif;text-transform:uppercase;letter-spacing:0.08em;">Tanggal dipilih</p>
                    <div class="session-date-badge">
                        <span>{{ \Carbon\Carbon::parse($tanggalDipilih)->translatedFormat('d F Y') }}</span>
                    </div>

                    @php
                        $sesiData = [
                            1 => ['jam' => '08.00', 'label' => 'Sesi Pagi'],
                            2 => ['jam' => '10.00', 'label' => 'Sesi Tengah'],
                            3 => ['jam' => '13.30', 'label' => 'Sesi Siang'],
                        ];
                        
                        // 🔒 LOGIKA BARU: Sesi otomatis dinonaktifkan jika tanggal yang dipilih berada dalam daftar gembok admin
                        $isSelectedDateDisabled = $tanggalDipilih < $today || in_array($tanggalDipilih, $lockedDates ?? []);

                        $currentTime = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                        $isToday = ($tanggalDipilih == $today);
                    @endphp

                    <div class="row g-3">
                        @foreach($sesiData as $num => $data)
                        @php
                            // Mengecek apakah jam sesi sudah terlewat di hari ini
                            $isSessionPassed = false;
                            if ($isToday) {
                                $jamSesi = str_replace('.', ':', $data['jam']); 
                                if ($currentTime >= $jamSesi) {
                                    $isSessionPassed = true;
                                }
                            }
                            
                            // Sesi tidak tersedia jika tanggal sudah lewat, masuk gembok admin, ATAU jam sesi di hari ini sudah terlewat
                            $isSesiTidakTersedia = $isSelectedDateDisabled || $isSessionPassed;
                        @endphp

                        <div class="col-12">
                            <div class="session-card {{ (isset($bookedSessions[$num]) || $isSesiTidakTersedia) ? 'full' : '' }}">

                                <div class="sesi-info">
                                    <div class="sesi-num">{{ $data['label'] }}</div>
                                    <div class="sesi-jam">
                                        {{ $data['jam'] }}
                                        <small style="font-size:0.8rem;font-weight:400;opacity:0.45;">WIB</small>
                                    </div>

                                    @if(isset($bookedSessions[$num]))
                                        <div class="sesi-booked-name">{{ $bookedSessions[$num]->instansi }}</div>
                                    @elseif(in_array($tanggalDipilih, $lockedDates ?? []))
                                        <div class="sesi-tag-lewat"><i class="fas fa-lock fa-xs me-1"></i> Jadwal dikunci oleh admin</div>
                                    @elseif($isSesiTidakTersedia)
                                        <div class="sesi-tag-lewat">Waktu sudah lewat</div>
                                    @else
                                        <div class="sesi-status-text">Slot tersedia untuk reservasi</div>
                                    @endif
                                </div>

                                <div class="sesi-action">
                                    @if(isset($bookedSessions[$num]) || $isSesiTidakTersedia)
                                        <button class="btn-sesi-disabled" disabled>tidak tersedia</button>
                                    @else
                                        <button class="btn-sesi-pilih" onclick="openBookingModal({{ $num }}, '{{ $tanggalDipilih }}')">
                                            Pilih
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-custom">
                <div class="modal-title-custom">Form Reservasi</div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal">✕</button>
            </div>
            <div class="modal-body-custom">
                <form action="{{ route('kunjungan.store') }}" method="POST" id="formKunjungan">
                    @csrf
                    <input type="hidden" name="tanggal_kunjungan" id="modal_tanggal">
                    <input type="hidden" name="sesi" id="modal_sesi">

                    <div class="row g-0">
                        <div class="col-12">
                            <label class="modal-label">Nama Lengkap Pemohon</label>
                            <input type="text" name="nama_pemohon" class="modal-input" placeholder="Nama Lengkap Anda" required>
                        </div>
                        <div class="col-12">
                            <label class="modal-label">Nama Instansi / Sekolah / Kelompok</label>
                            <input type="text" name="instansi" class="modal-input" placeholder="Contoh: SMK Negeri 1 Lumajang" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="modal-label">Jumlah Pengunjung</label>
                            <input type="number" name="jumlah_pengunjung" class="modal-input" placeholder="Contoh: 30" min="1" required>
                        </div>

                        <div class="col-md-6 pe-md-1">
                            <label class="modal-label">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="modal-input" placeholder="081234567890" required>
                        </div>
                        <div class="col-md-6 ps-md-1">
                            <label class="modal-label">Alamat Email</label>
                            <input type="email" name="email" class="modal-input" placeholder="nama@email.com" required>
                        </div>
                        <div class="col-12">
                            <label class="modal-label">Keperluan / Catatan (Opsional)</label>
                            <textarea name="keperluan" class="modal-input" placeholder="Ceritakan singkat tujuan kunjungan..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-modal-submit" id="btnSubmitKunjungan">Kirim Permohonan Reservasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openBookingModal(sesi, tanggal) {
        document.getElementById('modal_sesi').value = sesi;
        document.getElementById('modal_tanggal').value = tanggal;
        var myModal = new bootstrap.Modal(document.getElementById('bookingModal'));
        myModal.show();
    }

    document.getElementById('formKunjungan').addEventListener('submit', function() {
        var btn = document.getElementById('btnSubmitKunjungan');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim Permohonan...';
    });
</script>
@endsection