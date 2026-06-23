@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- ── HEADER DASHBOARD ─────────────────────────────────────── -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold h2 mb-1 text-dark" style="letter-spacing: -0.5px;">Dashboard Ringkasan</h1>
            <p class="text-muted small mb-0">Selamat datang kembali di panel administrasi P4S Gubuk Sayur Lumajang.</p>
        </div>
        <div class="text-muted small fw-medium">
            <i class="fas fa-calendar-alt me-1"></i> {{ date('d M Y') }}
        </div>
    </div>

    <!-- ── ROW CARD STATISTIK ───────────────────────────────────── -->
    <div class="row g-3 mb-4">
        <!-- CARD: TOTAL PENDAPATAN -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white h-100 shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 opacity-75 fw-bold small" style="letter-spacing: 1px;">Total Pendapatan Pelatihan</h6>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
                        </div>
                        <div class="display-5 opacity-50">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: TOTAL KELAS -->
        <div class="col-xl-2 col-md-3 col-6">
            <div class="card bg-white text-dark h-100 shadow-sm border-0" style="border-radius: 16px; border-left: 5px solid #0d6efd !important;">
                <div class="card-body p-3 d-flex flex-column justify-content-center">
                    <span class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Kelas</span>
                    <h3 class="fw-bold text-primary mb-0">{{ $total }}</h3>
                    <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                        <span class="text-success fw-bold">{{ $open }} Buka</span> | <span class="text-danger fw-bold">{{ $closed }} Tutup</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: TOTAL PESAN -->
        <div class="col-xl-3 col-md-3 col-6">
            <div class="card bg-white text-dark h-100 shadow-sm border-0" style="border-radius: 16px; border-left: 5px solid #ffc107 !important;">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pesan Masuk</span>
                        <h3 class="fw-bold text-warning mb-0">{{ $total_pesan }}</h3>
                    </div>
                    <div class="fs-2 text-warning opacity-25">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── ROW GRAFIK & PESAN TERBARU ────────────────────────────── -->
    <div class="row g-4">
        <!-- SEKSI GRAFIK OMZET -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; background: white;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">
                        <i class="fas fa-chart-line text-success me-2"></i>Grafik Pendapatan Bulanan ({{ date('Y') }})
                    </h5>
                    <span class="badge bg-light text-success border border-success px-3 rounded-pill">Real-time</span>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="position: relative; height:320px; width:100%">
                        <canvas id="chartPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEKSI PESAN TERBARU -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; background: white;">
                <div class="card-header bg-white py-3 border-0" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">
                        <i class="fas fa-comment-alt text-warning me-2"></i>Kontak Pesan Terbaru
                    </h5>
                </div>
                <div class="card-body p-3 pt-0">
                    <div class="list-group list-group-flush">
                        @forelse($pesan_terbaru as $pesan)
                            <div class="list-group-item px-0 py-3 border-bottom border-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $pesan->nama }}</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $pesan->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="text-muted d-block small mb-2" style="font-size: 0.8rem;">{{ $pesan->email }}</span>
                                <p class="text-secondary small mb-0 bg-light p-2 rounded-3 text-truncate" style="max-width: 100%;">
                                    "{{ $pesan->pesan ?? $pesan->isi_pesan }}"
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-comment-slash fa-2x text-muted mb-2 opacity-50"></i>
                                <p class="text-muted small mb-0">Belum ada pesan masuk dari pengunjung.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── SCRIPT INTEGRASI CHART.JS DENGAN LARAVEL DATA ─────────── -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('chartPendapatan').getContext('2d');
        
        // Gradasi warna hijau di bawah garis grafik agar terlihat premium
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(25, 135, 84, 0.25)');
        gradient.addColorStop(1, 'rgba(25, 135, 84, 0.00)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan Terverifikasi',
                    data: @json($pendapatan_bulanan),
                    borderColor: '#198754',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#198754',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return ' Pendapatan: Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.03)' },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000) + ' Jt';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000) + ' Rb';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection