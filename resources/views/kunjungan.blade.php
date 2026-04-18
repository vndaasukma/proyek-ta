@extends('layouts.frontend')

@section('content')
@php
    $themeColor = \App\Models\Setting::where('key', 'theme_color')->value('value') ?? '#198754';
    
    // Logika Kalender Dinamis
    $startOfMonth = $carbonDate->copy()->startOfMonth();
    $blankDays = $startOfMonth->dayOfWeek;
    $daysInMonth = $carbonDate->daysInMonth;
    $today = date('Y-m-d'); // Tanggal hari ini
@endphp

<style>
    :root { 
        --p4s-green: {{ $themeColor }}; 
        --p4s-dark-green: #0d2b1d; 
    }

    /* HEADER */
    .header-kunjungan {
        height: 40vh;
        background: linear-gradient(rgba(25, 135, 84, 0.8), rgba(13, 43, 29, 0.6)), 
                    url('{{ asset('assets/img/p4s-hero.jpg') }}');
        background-size: cover; background-position: center;
        display: flex; align-items: center; color: white;
    }

    /* KALENDER STYLE PREMIUM */
    .calendar-container { 
        background: var(--p4s-dark-green); 
        border-radius: 30px; padding: 40px; color: white; 
        margin-top: -50px; position: relative; z-index: 10; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }
    .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; text-align: center; }
    .day-name { font-weight: bold; opacity: 0.6; padding-bottom: 10px; font-size: 0.8rem; }
    
    .date-item { 
        padding: 15px 5px; border-radius: 10px; cursor: pointer; transition: 0.3s; 
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        text-decoration: none; color: white;
    }
    .date-item:hover:not(.disabled) { background: rgba(255, 255, 255, 0.1); color: white; }
    .date-item.active { 
        background: var(--p4s-green) !important; 
        box-shadow: 0 0 20px rgba(25, 135, 84, 0.4); 
        color: white;
    }
    /* Style untuk tanggal dinonaktifkan (yang sudah lewat) */
    .date-item.disabled {
        opacity: 0.2;
        cursor: not-allowed;
    }

    /* Indikator Titik Status */
    .dots { display: flex; gap: 3px; margin-top: 5px; }
    .dot { width: 6px; height: 6px; border-radius: 50%; }
    .dot.available { background: #2ecc71; }
    .dot.booked { background: #e74c3c; }

    /* SESSION SECTION */
    #session-container { padding-top: 50px; }
    .selected-date-title { 
        display: inline-block; padding: 10px 40px; 
        border: 2px solid var(--p4s-dark-green); 
        color: var(--p4s-dark-green);
        font-weight: 800; text-transform: uppercase; margin-bottom: 40px;
        border-radius: 50px;
    }
    
    .session-card {
        background: var(--p4s-dark-green); color: white; border-radius: 20px; padding: 30px;
        text-align: center; transition: 0.3s; height: 100%;
        border-bottom: 8px solid var(--p4s-green);
    }
    .session-card.full { background: #1a1a1a; border-bottom: 8px solid #555; }

    .btn-session { 
        border: none; padding: 12px 25px; 
        border-radius: 50px; font-weight: bold; width: 100%; margin-top: 20px;
    }
    .btn-available { background: var(--p4s-green); color: white; }
    .btn-available:hover { opacity: 0.9; transform: scale(1.05); transition: 0.3s; }
</style>

<header class="header-kunjungan">
    <div class="container text-center text-md-start">
        <h1 class="display-3 fw-bold text-lowercase" style="letter-spacing: -2px;">kunjungan edukatif.</h1>
        <p class="fs-5 fw-light">pilih tanggal kunjungan untuk reservasi sesi.</p>
    </div>
</header>

<div class="container mb-5">
    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-pill px-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ALERT ERROR VALIDASI --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4" role="alert">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="calendar-container shadow-lg">
        <div class="calendar-header">
            <h3 class="fw-bold mb-0 text-capitalize">{{ $carbonDate->translatedFormat('F Y') }}</h3>
            <div class="d-flex gap-2">
                <a href="?date={{ $carbonDate->copy()->subMonth()->format('Y-m-d') }}" class="btn btn-outline-light btn-sm rounded-circle"><i class="fas fa-chevron-left"></i></a>
                <a href="?date={{ $carbonDate->copy()->addMonth()->format('Y-m-d') }}" class="btn btn-outline-light btn-sm rounded-circle"><i class="fas fa-chevron-right"></i></a>
            </div>
        </div>

        <div class="calendar-grid">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
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
                    $isDisabled = $currentDate < $today; // Cek apakah tanggal sudah lewat
                @endphp
                {{-- Tanggal dinonaktifkan jika sudah lewat (kemarin dan sebelumnya) --}}
                <a href="{{ $isDisabled ? '#' : '?date=' . $currentDate }}" class="date-item {{ $active }} {{ $isDisabled ? 'disabled' : '' }}">
                    <span class="date-number">{{ $day }}</span>
                    <div class="dots">
                        @for($s = 1; $s <= 3; $s++)
                            <div class="dot {{ $s <= $bookedCount ? 'booked' : 'available' }}"></div>
                        @endfor
                    </div>
                </a>
            @endfor
        </div>
    </div>

    <section id="session-container" class="text-center">
        <p class="text-muted mb-1">tanggal dipilih:</p>
        <div class="selected-date-title">{{ \Carbon\Carbon::parse($tanggalDipilih)->translatedFormat('d F Y') }}</div>
        
        <div class="row g-4 justify-content-center mt-2">
            @php
                $sesiData = [
                    1 => ['jam' => '08.00 wib', 'label' => 'sesi 1'],
                    2 => ['jam' => '10.00 wib', 'label' => 'sesi 2'],
                    3 => ['jam' => '13.30 wib', 'label' => 'sesi 3'],
                ];
                $isSelectedDateDisabled = $tanggalDipilih < $today; // Cek tanggal dipilih sudah lewat
            @endphp

            @foreach($sesiData as $num => $data)
            <div class="col-md-4">
                <div class="session-card {{ isset($bookedSessions[$num]) ? 'full' : '' }}">
                    <small class="text-uppercase opacity-70">{{ $data['label'] }}</small>
                    <h2 class="fw-bold mt-2">{{ $data['jam'] }}</h2>
                    
                    @if(isset($bookedSessions[$num]))
                        <p class="small opacity-70 mt-3 text-truncate">{{ $bookedSessions[$num]->instansi }}</p>
                        <button class="btn btn-session bg-secondary text-white" disabled>tidak tersedia</button>
                    @elseif($isSelectedDateDisabled)
                        <p class="small text-danger mt-3">Tanggal sudah lewat</p>
                        <button class="btn btn-session bg-secondary text-white" disabled>tidak tersedia</button>
                    @else
                        <p class="small opacity-70 mt-3">Slot tersedia untuk reservasi</p>
                        <button class="btn btn-session btn-available" onclick="openBookingModal({{ $num }}, '{{ $tanggalDipilih }}')">pilih sesi</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

{{-- MODAL FORM --}}
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 border-0 shadow-lg" style="border-radius: 30px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-success">Form Reservasi Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal_kunjungan" id="modal_tanggal">
                    <input type="hidden" name="sesi" id="modal_sesi">
                    
                    <div class="mb-3">
                        <label class="small fw-bold">Nama Lengkap Pemohon</label>
                        <input type="text" name="nama_pemohon" class="form-control rounded-pill px-3" placeholder="Nama Lengkap Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nama Instansi / Sekolah / Kelompok</label>
                        <input type="text" name="instansi" class="form-control rounded-pill px-3" placeholder="Contoh: SMK Negeri 1 Lumajang" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nomor WhatsApp Aktif</label>
                        <input type="text" name="no_wa" class="form-control rounded-pill px-3" placeholder="081234567890" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Keperluan / Catatan Tambahan (Opsional)</label>
                        <textarea name="keperluan" class="form-control rounded-4 px-3" rows="3" placeholder="Ceritakan singkat tujuan kunjungan atau catatan khusus..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold mt-3">Kirim Permohonan Reservasi</button>
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
</script>
@endsection