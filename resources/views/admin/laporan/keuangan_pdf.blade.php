<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
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
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 8px; text-align: left; }
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
        <h3>Laporan Pendapatan Pelatihan</h3>
        <p>Tanggal Cetak: {{ $tanggal_cetak }}</p>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="18%">Tanggal Transaksi</th>
                <th width="27%">Nama Peserta</th>
                <th width="30%">Kelas Pelatihan</th>
                <th class="text-right" width="20%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemasukan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}</td>
                <td>{{ $item->nama ?? $item->nama_peserta ?? 'Nama Tidak Terdata' }}</td>
                <td>{{ $item->pelatihan->title ?? $item->pelatihan->nama_pelatihan }}</td>
                <td class="text-right">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="font-style: italic;">Belum ada data pemasukan yang berstatus Lunas.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right" style="background-color: #f8f9fa; color: #000; font-weight: bold;">TOTAL PENDAPATAN BERSIH</th>
                <th class="text-right fw-bold" style="background-color: #f8f9fa; color: #198754;">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>