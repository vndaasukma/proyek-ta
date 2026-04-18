<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Persetujuan Kemitraan</title>
    <style>
        /* Setup Dasar Surat Resmi */
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; color: #000; margin: 0.5cm; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 25px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16pt; }
        .header p { margin: 0; font-size: 10pt; }
        
        .title { text-align: center; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-top: 30px; font-size: 14pt; }
        .content { margin-top: 35px; text-align: justify; }
        
        /* Area Tanda Tangan & Stempel */
        .signature-section {
            margin-top: 60px;
            float: right;
            width: 300px;
            position: relative; /* Container utama untuk posisi absolute di dalamnya */
        }
        .signature-section p { margin: 0; }
        .nama-pejabat { margin-top: 90px; font-weight: bold; text-decoration: underline; }

        /* Tanda tangan (Layer Bawah) */
        .img-ttd {
            position: absolute;
            width: 160px;
            top: 20px;
            left: 40px;
            z-index: 1;
        }

        /* Stempel (Layer Atas - Miring Estetik) */
        .img-stempel {
            position: absolute;
            width: 135px;
            top: 10px;
            left: 0px;
            z-index: 2; /* Di atas tanda tangan */
            opacity: 0.85;
            transform: rotate(-15deg); /* Efek stempel asli yang miring */
        }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <h2>p4s gubuk sayur lumajang</h2>
        <p>pusat pelatihan pertanian dan perdesaan swadaya</p>
        <p>dusun krajan, desa kedawung, kec. padang, kab. lumajang, jawa timur 67352</p>
    </div>

    <p style="text-align: right;">lumajang, {{ date('d F Y') }}</p>

    <div class="title">surat persetujuan kemitraan resmi</div>

    <div class="content">
        yang bertanda tangan di bawah ini, pengelola p4s gubuk sayur menerangkan bahwa: <br><br>
        <table>
            <tr>
                <td width="150">nama instansi/mitra</td>
                <td>: <strong>{{ $data->nama_instansi ?? $data->nama_perusahaan ?? 'data tidak tersedia' }}</strong></td>
            </tr>
            <tr>
                <td>perwakilan resmi</td>
                <td>: {{ $data->nama_perwakilan ?? $data->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>keperluan</td>
                <td>: kerjasama strategis p4s gubuk sayur</td>
            </tr>
        </table>
        <br>
        telah melalui tahap verifikasi dan dinyatakan <strong>disetujui</strong> untuk menjalin kerjasama secara resmi. surat ini dibuat secara otomatis melalui sistem informasi p4s gubuk sayur dan sah digunakan sebagaimana mestinya.
    </div>

    <div class="signature-section">
        <p>hormat kami,</p>
        <p>ketua p4s gubuk sayur</p>
        
        {{-- Tanda Tangan --}}
        <img src="{{ public_path('assets/img/ttdsample.png') }}" class="img-ttd">
        
        {{-- Stempel Melayang --}}
        <img src="{{ public_path('assets/img/stempelsample.png') }}" class="img-stempel">
        
        <p class="nama-pejabat">Ahmad Rofi</p>
    </div>
    <div class="clear"></div>

</body>
</html>