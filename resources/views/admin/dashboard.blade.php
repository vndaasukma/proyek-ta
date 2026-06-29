@extends('admin.layout')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f4f7f6;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold h3 mb-1 text-dark" style="letter-spacing: -0.5px;">Dashboard Pimpinan</h1>
            <p class="text-muted small mb-0">Ringkasan performa dan metrik P4S Gubuk Sayur.</p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('admin.laporan.pengunjung') }}" target="_blank" class="btn btn-outline-secondary btn-sm shadow-sm d-flex align-items-center rounded-3 px-3">
                <i class="fas fa-print me-2"></i> Rekap Pengunjung
            </a>
            <a href="{{ route('admin.laporan.keuangan') }}" target="_blank" class="btn btn-danger btn-sm shadow-sm d-flex align-items-center rounded-3 px-3">
                <i class="fas fa-file-pdf me-2"></i> Laporan Keuangan
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%); border-radius: 15px;">
        <div class="card-body p-4 text-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-seedling me-2"></i>Pusat Kendali Sistem</h4>
                <p class="mb-0 opacity-75 small">Pantau performa pelatihan, pengunjung, dan omzet secara real-time.</p>
            </div>
            <div class="d-none d-md-block text-end">
                <span class="d-block fw-bold fs-5">{{ date('d F Y') }}</span>
                <span class="small opacity-75">Tahun Ajaran {{ date('Y') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <div class="card bg-white border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 6px solid #198754 !important;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-uppercase fw-bold text-muted mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Akumulasi Omzet Lunas</p>
                        <h2 class="fw-bold text-dark mb-0">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
                        <span class="badge bg-success-subtle text-success mt-2 px-3 py-2 rounded-pill small">
                            <i class="fas fa-check-circle me-1"></i> Terverifikasi Sistem
                        </span>
                    </div>
                    <div class="p-3 bg-light rounded-circle text-success" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card bg-white border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                    <p class="fw-bold text-secondary mb-2 small">Web Hits Hari Ini</p>
                    <h2 class="display-6 fw-bold text-primary mb-0">{{ number_format($pengunjung_hari_ini, 0, ',', '.') }}</h2>
                    <p class="text-muted small mt-2 mb-0"><i class="fas fa-globe me-1"></i> Dilacak via IP aktif</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6">
            <div class="card bg-white border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-3 text-center">
                    <p class="fw-bold text-secondary mb-1 small">Total Program</p>
                    <h3 class="fw-bold text-dark mb-2">{{ $total }}</h3>
                    <div class="d-flex justify-content-between px-2 small">
                        <span class="text-success fw-bold" title="Kelas Buka">{{ $open }} <i class="fas fa-door-open"></i></span>
                        <span class="text-danger fw-bold" title="Kelas Tutup">{{ $closed }} <i class="fas fa-lock"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6">
            <div class="card bg-white border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-3 text-center d-flex flex-column justify-content-center">
                    <p class="fw-bold text-secondary mb-2 small">Pesan Baru</p>
                    <h2 class="fw-bold text-warning mb-0">{{ $total_pesan }}</h2>
                    <p class="text-muted small mt-1 mb-0"><i class="fas fa-envelope"></i> Inbox</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-bold text-dark mb-1">Performa 7 Hari Terakhir</h6>
                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($total_minggu_ini, 0, ',', '.') }}</h4>
                </div>
                <div class="card-body p-4 pt-2">
                    <div style="height: 280px;">
                        <canvas id="grafikMingguan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between">
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Tren Penerimaan Pendapatan</h6>
                        <p class="text-muted small mb-0">Periode Tahun {{ date('Y') }}</p>
                    </div>
                    <i class="fas fa-chart-area text-success opacity-50 fa-2x"></i>
                </div>
                <div class="card-body p-4 pt-2">
                    <div style="height: 280px;">
                        <canvas id="grafikTahunan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 p-4 pb-2">
            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-inbox text-success me-2"></i>Kontak Masuk Pengunjung Website</h6>
        </div>
        <div class="card-body p-4 pt-0">
            @if($pesan_terbaru->isEmpty())
                <div class="text-center py-4 bg-light rounded-3">
                    <p class="text-muted mb-0">Semua pesan telah ditangani. Tidak ada antrean interaksi baru.</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($pesan_terbaru as $pesan)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded-3 bg-light h-100" style="border-color: #e9ecef !important;">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong class="text-dark">{{ $pesan->nama }}</strong>
                                    <span class="badge bg-white text-secondary border small">{{ $pesan->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-success small mb-2"><i class="fas fa-at me-1"></i> {{ $pesan->email }}</div>
                                <p class="text-secondary small mb-0 fw-medium" style="line-height: 1.4;">
                                    "{{ Str::limit($pesan->pesan ?? $pesan->isi_pesan, 80) }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. GRAFIK MINGGUAN (HORIZONTAL BAR)
        const ctxMinggu = document.getElementById('grafikMingguan').getContext('2d');
        new Chart(ctxMinggu, {
            type: 'bar',
            data: {
                labels: @json($label_mingguan),
                datasets: [{
                    label: 'Omzet',
                    data: @json($pendapatan_mingguan),
                    backgroundColor: '#20c997',
                    borderRadius: 6, 
                    barThickness: 12
                }]
            },
            options: {
                indexAxis: 'y', // Mengubah jadi grafik menyamping
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        display: false,
                        beginAtZero: true
                    },
                    y: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { font: { size: 12, weight: 'bold' }, color: '#6c757d' }
                    }
                }
            }
        });

        // 2. GRAFIK TAHUNAN (GAYA TEGAS)
        const ctxTahun = document.getElementById('grafikTahunan').getContext('2d');
        new Chart(ctxTahun, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Rp',
                    data: @json($pendapatan_bulanan),
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)', 
                    borderWidth: 3,
                    fill: true,
                    tension: 0.1,
                    pointRadius: 4, 
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#198754',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { color: '#f8f9fa' },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        border: { display: false },
                        grid: { borderDash: [5, 5] }, 
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + ' Jt';
                                if (value >= 1000) return (value / 1000) + ' Rb';
                                return value;
                            }
                        }
                    }
                }
            }
        });

    });
</script>
@endsection