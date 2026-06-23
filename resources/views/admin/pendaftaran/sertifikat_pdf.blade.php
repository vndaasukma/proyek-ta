<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Resmi Pelatihan - P4S Gubuk Sayur</title>
    <style>
        /* Menggunakan Margin Kertas Otomatis Bawaan DomPDF */
        @page { 
            size: a4 landscape; 
            margin: 30px; 
        }
        body { 
            font-family: 'Georgia', serif; 
            background-color: #fbfbfa; /* Warna krem piagam resmi */
            margin: 0; 
            padding: 25px;
            border: 4px solid #198754; /* Bingkai Hijau Utama */
            color: #2D3748;
        }
        
        /* Bingkai Garis Tipis Bagian Dalam */
        .inner-border {
            border: 1px solid #198754;
            padding: 30px 40px;
            text-align: center;
            box-sizing: border-box;
        }
        
        /* Bagian KOP / Header */
        .header h1 {
            font-size: 36px;
            margin: 0;
            color: #198754;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            font-size: 13px;
            margin: 5px 0 0 0;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #4A5568;
            font-weight: bold;
        }
        
        /* Garis Aksen Emas Mewah */
        .gold-line {
            width: 160px;
            height: 2px;
            background-color: #d4af37;
            margin: 12px auto;
        }
        
        /* Nomor Sertifikat */
        .nomor-sertifikat {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            font-weight: bold;
            color: #4A5568;
            margin-bottom: 20px;
        }
        
        /* Teks Pengantar */
        .statement {
            font-size: 15px;
            font-style: italic;
            color: #718096;
        }
        
        /* Nama Peserta */
        .nama-peserta {
            font-size: 34px;
            font-weight: bold;
            color: #111111;
            margin: 8px auto 15px auto;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Narasi Keterangan */
        .reason {
            font-size: 14px;
            max-width: 720px;
            margin: 0 auto 35px auto;
            line-height: 1.6;
            color: #4A5568;
        }
        .reason strong {
            color: #198754;
        }
        
        /* Tabel Tanda Tangan Mengalir Alami (Anti-Gagal) */
        .footer-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .signature-section {
            width: 45%;
            text-align: center;
            vertical-align: top;
        }
        
        /* Batas Ukuran Gambar TTD */
        .space-ttd {
            height: 70px;
            margin: 5px 0;
        }
        .img-ttd {
            max-height: 70px;
            max-width: 170px;
            object-fit: contain;
        }
        
        /* Nama Penandatangan */
        .line-name {
            font-weight: bold;
            color: #111111;
            font-size: 15px;
            border-bottom: 1px solid #4A5568;
            display: inline-block;
            padding-bottom: 1px;
        }
        .sub-title {
            color: #718096;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="inner-border">
    
    <!-- Header Dokumen -->
    <div class="header">
        <h1>Sertifikat Pelatihan</h1>
        <p>P4S Gubuk Sayur Kabupaten Lumajang</p>
    </div>

    <!-- Garis Dekoratif Emas -->
    <div class="gold-line"></div>

    <!-- Kode Registrasi -->
    <div class="nomor-sertifikat">
        No: {{ $nomor_sertifikat }}
    </div>

    <div class="statement">Diberikan Kepada :</div>
    
    <!-- Nama Lengkap Pendaftar -->
    <div class="nama-peserta">
        {{ $nama_peserta }}
    </div>

    <!-- Detail Keterangan -->
    <div class="reason">
        Atas partisipasi dan keberhasilannya menyelesaikan seluruh rangkaian agenda kegiatan pelatihan vokasi pertanian bertajuk 
        <strong>"{{ $nama_pelatihan }}"</strong> yang diselenggarakan oleh Pusat Pelatihan Pertanian dan Perdesaan Swadaya (P4S) Gubuk Sayur pada tanggal {{ $tanggal }}.
    </div>

    <!-- Area Validasi Tanda Tangan Alami -->
    <table class="footer-table">
        <tr>
            <!-- Sisi Kiri: Ketua P4S -->
            <td class="signature-section">
                <div style="color: #2D3748; font-size: 13px;">Penyelenggara,</div>
                <div class="space-ttd">
                    @if($img_ttd_ketua)
                        <img src="{{ $img_ttd_ketua }}" class="img-ttd">
                    @endif
                </div>
                <div class="line-name">{{ $nama_ketua }}</div>
                <div class="sub-title">Ketua P4S Gubuk Sayur</div>
            </td>
            
            <!-- Spacer Tengah -->
            <td style="width: 10%;"></td>

            <!-- Sisi Kanan: Instruktur Pelatih -->
            <td class="signature-section">
                <div style="color: #2D3748; font-size: 13px;">Instruktur / Pelatih,</div>
                <div class="space-ttd">
                    @if($img_ttd_pelatih)
                        <img src="{{ $img_ttd_pelatih }}" class="img-ttd">
                    @else
                        <div style="padding-top: 20px; color:#a0aec0; font-style: italic; font-size: 12px;">(Belum upload TTD)</div>
                    @endif
                </div>
                <div class="line-name">{{ $nama_pelatih }}</div>
                <div class="sub-title">Widyaiswara / Pelatih Utama</div>
            </td>
        </tr>
    </table>
    
</div>

</body>
</html>