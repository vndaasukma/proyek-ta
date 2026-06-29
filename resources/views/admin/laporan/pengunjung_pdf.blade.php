<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekap Pengunjung Web</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11pt; line-height: 1.5; color: #333; margin: 0.5cm; }
        
        /* Desain Kop Surat Resmi */
        .kop-table { 
            width: 100%; 
            border-collapse: collapse; 
            border-bottom: 4px double #000; 
            padding-bottom: 12px; 
            margin-bottom: 20px; 
        }
        .kop-logo { width: 15%; text-align: left; vertical-align: middle; }
        .kop-text { width: 70%; text-align: center; vertical-align: middle; }
        .kop-text h1 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; color: #000; }
        .kop-text h2 { margin: 2px 0 0 0; font-size: 11pt; font-weight: normal; color: #000; }
        .kop-text p { margin: 4px 0 0 0; font-size: 9pt; color: #000; }
        
        .title-section { text-align: center; margin: 25px 0 15px 0; }
        .title-section h3 { margin: 0; font-size: 13pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; }
        .title-section p { margin: 5px 0 0; font-size: 10pt; color: #555; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 10px; text-align: left; }
        table.data-table th { background-color: #198754; color: white; text-transform: uppercase; font-size: 11px; text-align: center; }
        table.data-table tr:nth-child(even) { background-color: #f8f9fa; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <table class="kop-table">
        <tr>
            <td class="kop-logo"><img src="{{ public_path('assets/img/LOGO P4S.png') }}" style="width: 80px; height: auto;"></td>
            <td class="kop-text">
                <h1>P4S Gubuk Sayur Lumajang</h1>
                <h2>Pusat Pelatihan Pertanian dan Perdesaan Swadaya</h2>
                <p>Dusun Krajan, RT.003 / RW.001, Desa Kedawung, Kecamatan Padang, Kabupaten Lumajang, Jawa Timur 67352</p>
            </td>
            <td class="kop-logo" style="text-align: right;"><img src="{{ public_path('assets/img/LOGO GUBUK SAYUR.png') }}" style="width: 80px; height: auto;"></td>
        </tr>
    </table>

    <div class="title-section">
        <h3>Laporan Rekap Pengunjung Website</h3>
        <p>Tanggal Cetak: {{ $tanggal_cetak }}</p>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="10%">No</th>
                <th width="35%">Tanggal</th>
                <th class="text-center" width="27%">Total IP Unik (Pengunjung)</th>
                <th class="text-center" width="28%">Total Halaman Dibuka (Hits)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengunjung as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                <td class="text-center">{{ number_format($item->total_unik, 0, ',', '.') }} IP</td>
                <td class="text-center">{{ number_format($item->total_klik, 0, ',', '.') }} Kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center" style="font-style: italic;">Belum ada data pengunjung yang terekam.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa;">
                <th colspan="2" class="text-right" style="color: #000; font-weight: bold;">TOTAL KESELURUHAN SEPANJANG WAKTU</th>
                <th class="text-center fw-bold" style="color: #198754;">{{ number_format($pengunjung->sum('total_unik'), 0, ',', '.') }} IP</th>
                <th class="text-center fw-bold" style="color: #198754;">{{ number_format($pengunjung->sum('total_klik'), 0, ',', '.') }} Kali</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>