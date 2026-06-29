<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Persetujuan Kemitraan</title>
    <style>
        /* Setup Dasaran Kertas Surat Resmi */
        @page {
            margin: 0.6cm 0cm;
        }
        body { 
            font-family: 'Times New Roman', serif; 
            font-size: 12pt; 
            line-height: 1.6; 
            color: #000; 
            margin-top: 0.4cm;
            margin-bottom: 0.8cm;
            /* LOCK MARGIN: Teks segaris lurus dengan batas border kop surat */
            margin-left: 2.2cm; 
            margin-right: 2.2cm; 
        }
        
        /* Desain Kop Surat Formal */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 4px double #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .kop-logo-left {
            width: 15%;
            text-align: left;
            vertical-align: middle;
        }
        .kop-logo-right {
            width: 15%;
            text-align: right;
            vertical-align: middle;
        }
        .kop-text {
            width: 70%;
            text-align: center;
            vertical-align: middle;
        }
        .kop-text h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-text h2 {
            margin: 2px 0 0 0;
            font-size: 11pt;
            font-weight: normal;
            text-transform: capitalize;
        }
        .kop-text p {
            margin: 4px 0 0 0;
            font-size: 9.5pt;
            line-height: 1.3;
        }

        .title { 
            text-align: center; 
            font-weight: bold; 
            text-decoration: underline; 
            text-transform: uppercase; 
            margin-top: 30px; 
            font-size: 13pt; 
        }

        .nomor-surat {
            text-align: center;
            font-size: 12pt;
            margin-top: 5px;
        }
        
        .content { 
            margin-top: 25px; 
            text-align: justify; /* Rata kanan-kiri */
            text-indent: 0.5in; 
        }
        
        .detail-table {
            margin: 20px auto 20px 0.5in;
            border-collapse: collapse;
            width: 90%;
        }
        .detail-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        /* Area Tanda Tangan & Stempel */
        .signature-container {
            margin-top: 45px;
            width: 100%;
        }
        .signature-section {
            float: right;
            width: 280px;
            position: relative;
        }
        .signature-section p { margin: 0; }
        .nama-pejabat { margin-top: 85px; font-weight: bold; text-decoration: underline; }

        .img-ttd {
            position: absolute;
            width: 160px;
            top: 15px;
            left: 30px;
            z-index: 1;
        }
        .img-stempel {
            position: absolute;
            width: 130px;
            top: 5px;
            left: -5px;
            z-index: 2;
            opacity: 0.90;
            transform: rotate(-12deg);
        }
        .clear { clear: both; }
    </style>
</head>
<body>

    @php
        $bulanAngka = date('n');
        $daftarRomawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulanRomawi = $daftarRomawi[$bulanAngka] ?? 'I';

        $daftarBulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $bulanIndo = $daftarBulanIndo[$bulanAngka] ?? 'Januari';
        $tanggalIndonesia = date('j') . ' ' . $bulanIndo . ' ' . date('Y');
        $idDinamis = sprintf('%03d', $data->id ?? 1);
    @endphp

    <!-- KOP SURAT FORMAL -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo-left">
                <img src="{{ public_path('assets/img/LOGO P4S.png') }}" style="width: 85px; height: auto;">
            </td>
            <td class="kop-text">
                <h1>P4S Gubuk Sayur Lumajang</h1>
                <h2>Pusat Pelatihan Pertanian dan Perdesaan Swadaya</h2>
                <p>Dusun Krajan, RT.003 / RW.001, Desa Kedawung, Kecamatan Padang,<br>Kabupaten Lumajang, Jawa Timur 67352</p>
            </td>
            <td class="kop-logo-right">
                <img src="{{ public_path('assets/img/LOGO GUBUK SAYUR.png') }}" style="width: 85px; height: auto;">
            </td>
        </tr>
    </table>

    <p style="text-align: right; margin-right: 5px;">Lumajang, {{ $tanggalIndonesia }}</p>

    <div class="title">Surat Persetujuan Kemitraan Resmi</div>
    <div class="nomor-surat">Nomor: GS/OL/{{ $idDinamis }}/{{ $bulanRomawi }}/{{ date('Y') }}</div>

    <div class="content">
        Yang bertanda tangan di bawah ini, pengelola Pusat Pelatihan Pertanian dan Perdesaan Swadaya (P4S) Gubuk Sayur Lumajang menerangkan dengan sebenarnya bahwa:
    </div>

    <table class="detail-table">
        <tr>
            <td width="160">Nama Instansi / Mitra</td>
            <td width="20">:</td>
            <td><strong>{{ $data->nama_instansi ?? $data->nama_perusahaan ?? 'Data Tidak Tersedia' }}</strong></td>
        </tr>
        <tr>
            <td>Perwakilan Resmi</td>
            <td>:</td>
            <td>{{ $data->nama_perwakilan ?? $data->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>Kerjasama dengan P4S Gubuk Sayur Lumajang</td>
        </tr>
    </table>

    <div class="content">
        Telah melalui tahapan verifikasi dokumen serta dinyatakan <strong>disetujui</strong> untuk menjalin ikatan kerjasama secara legal. Surat persetujuan kemitraan resmi ini diterbitkan secara otomatis melalui sistem informasi layanan P4S Gubuk Sayur Lumajang dan sah dipergunakan sebagaimana mestinya.
    </div>

    <div class="signature-container">
        <div class="signature-section">
            <p>Hormat kami,</p>
            <p>Ketua P4S Gubuk Sayur</p>
            
            <img src="{{ public_path('assets/img/ttdsample.png') }}" class="img-ttd">
            <img src="{{ public_path('assets/img/stempelsample.png') }}" class="img-stempel">
            
            <p class="nama-pejabat">Ahmad Rofi</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>