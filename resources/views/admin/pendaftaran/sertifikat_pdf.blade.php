<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat Resmi Kelulusan - P4S Gubuk Sayur</title>
    <style>
        /* Dasaran Kertas A4 Landscape */
        @page { 
            size: A4 landscape; 
            margin: 0; 
        }
        
        html, body { 
            margin: 0; 
            padding: 0; 
            width: 100%; 
            height: 100%; 
            font-family: 'Times New Roman', Times, serif; 
            background-color: #ffffff;
            color: #1a1a1a;
            -webkit-print-color-adjust: exact;
        }

        .certificate-container {
            position: relative;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            box-sizing: border-box;
            background: #ffffff;
        }

        /* Bingkai Hijau Tua Luxury */
        .outer-border {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 3px solid #14532d;
            box-sizing: border-box;
            z-index: 10;
        }
        .inner-border {
            position: absolute;
            top: 6px; left: 6px; right: 6px; bottom: 6px;
            border: 1px solid #14532d;
            box-sizing: border-box;
        }

        .corner-line {
            position: absolute; width: 30px; height: 30px; z-index: 12;
        }
        .tl { top: 23px; left: 23px; border-top: 3px solid #14532d; border-left: 3px solid #14532d; }
        .tr { top: 23px; right: 23px; border-top: 3px solid #14532d; border-right: 3px solid #14532d; }
        .bl { bottom: 23px; left: 23px; border-bottom: 3px solid #14532d; border-left: 3px solid #14532d; }
        .br { bottom: 23px; right: 23px; border-bottom: 3px solid #14532d; border-right: 3px solid #14532d; }

        .watermark-bg {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            opacity: 0.06;
            z-index: 1;
        }

        .page-background {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1000;
        }
        .page-background img { width: 100%; height: 100%; }

        /* HEADER JUDUL (REVISI: Diturunkan 75px kebawah agar proposional) */
        .header-table {
            width: 86%;
            margin: 75px auto 0 auto; 
            border-collapse: collapse;
            z-index: 20;
            position: relative;
        }
        .header-logo-left { width: 12%; text-align: left; vertical-align: middle; }
        .header-logo-right { width: 12%; text-align: right; vertical-align: middle; }
        .header-center-title { width: 76%; text-align: center; vertical-align: middle; }

        .title-main {
            font-family: 'Arial', sans-serif;
            font-size: 40px;
            font-weight: bold;
            color: #14532d;
            letter-spacing: 6px;
            margin: 0;
            text-transform: uppercase;
        }
        .title-institution {
            font-family: 'Arial', sans-serif;
            font-size: 15px;
            font-weight: bold;
            color: #3f6212;
            letter-spacing: 2px;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }

        .badge-nomor {
            display: inline-block;
            background-color: #14532d;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
            padding: 5px 25px;
            margin: 15px 0 25px 0;
            border-radius: 3px;
        }

        .content-box {
            position: relative;
            width: 100%;
            text-align: center;
            z-index: 15;
        }

        .label-diberikan {
            font-size: 16px;
            color: #4b5563;
            font-style: italic;
            margin-bottom: 8px;
        }

        .nama-peserta {
            font-family: 'Georgia', serif;
            font-size: 44px;
            font-style: italic;
            font-weight: bold;
            color: #14532d;
            margin-bottom: 5px;
            display: inline-block;
            text-transform: uppercase;
        }

        .divider-flourish {
            width: 30%;
            height: 1px;
            background: #14532d;
            margin: 12px auto 18px auto;
            position: relative;
        }
        .divider-flourish::after {
            content: "";
            position: absolute;
            top: -4px; 
            left: 50%;
            margin-left: -4px;
            width: 8px; 
            height: 8px;
            background: #14532d;
            transform: rotate(45deg);
        }

        .label-sebagai {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 2px;
        }
        .role-peserta {
            font-family: 'Arial', sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .keterangan-pelatihan {
            width: 76%;
            margin: 0 auto;
            font-size: 16px;
            color: #27272a;
            line-height: 1.6;
            text-align: justify;
        }

        .issuance-metadata {
            width: 100%;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .ttd-table {
            width: 82%;
            margin: 0 auto;
            border-collapse: collapse;
            z-index: 25;
            position: relative;
        }
        .ttd-col {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }
        
        .label-jabatan {
            font-size: 14px;
            color: #333333;
            margin-bottom: 5px;
        }
        .wrap-signature {
            height: 70px;
            display: block;
            margin: 2px auto;
        }
        .wrap-signature img {
            height: 70px;
            max-width: 140px;
        }
        
        .nama-penandatangan {
            font-weight: bold;
            color: #111827;
            font-size: 15px;
            border-bottom: 1px solid #14532d;
            display: inline-block;
            padding-bottom: 1px;
        }
        .sub-detail-reg {
            font-size: 11px;
            color: #6b7280;
            margin-top: 3px;
        }
    </style>
</head>
<body>

@php
    $dateSource = $item->pelatihan?->tanggal_pelatihan ?? $item->tanggal_daftar;
    $carbonDate = \Carbon\Carbon::parse($dateSource);
    $bulanAngka = $carbonDate->format('n');
    $romawiArr = ['','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
    $bulanRomawi = $romawiArr[$bulanAngka] ?? 'VI';
    $tahunSurat = $carbonDate->format('Y');

    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $tanggalResmi = $carbonDate->format('d') . ' ' . ($bulanIndo[$bulanAngka] ?? 'Juni') . ' ' . $tahunSurat;

    $namaPelatihan = $item->pelatihan->title ?? $item->pelatihan->nama_pelatihan ?? '';
    if (strtolower(substr($namaPelatihan, 0, 9)) === 'pelatihan') {
        $namaPelatihan = trim(substr($namaPelatihan, 9));
    }
@endphp

<div class="certificate-container">
    
    @if($template_url && !str_contains($template_url, 'sertifikat-default.png'))
        <div class="page-background">
            <img src="{{ $template_url }}" alt="Template Gambar Eksternal">
        </div>
    @else
        <div class="outer-border">
            <div class="inner-border"></div>
        </div>
        <div class="corner-line tl"></div>
        <div class="corner-line tr"></div>
        <div class="corner-line bl"></div>
        <div class="corner-line br"></div>

        <svg class="watermark-bg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#14532d"/>
            <path d="M6.5 12C6.5 8.96 8.96 6.5 12 6.5C13.04 6.5 14.01 6.79 14.85 7.3L15.95 6.2C14.81 5.45 13.46 5 12 5C8.13 5 5 8.13 5 12C5 13.46 5.45 14.81 6.2 15.95L7.3 14.85C6.79 14.01 6.5 13.04 6.5 12Z" fill="#14532d"/>
        </svg>
    @endif

    <table class="header-table">
        <tr>
            <td class="header-logo-left">
                <svg width="65" height="65" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3C7.03 3 3 7.03 3 12C3 16.97 7.03 21 12 21C16.97 21 21 16.97 21 12C21 7.03 16.97 3 12 3ZM12 18C8.69 18 6 15.31 6 12C6 10.45 6.59 9.04 7.56 7.97L16.03 16.44C14.96 17.41 13.55 18 12 18ZM16.44 16.03L7.97 7.56C9.04 6.59 10.45 6 12 6C15.31 6 18 8.69 18 12C18 13.55 17.41 14.96 16.44 16.03Z" fill="#14532d"/>
                </svg>
            </td>
            <td class="header-center-title">
                <h1 class="title-main">Sertifikat Pelatihan</h1>
                <h3 class="title-institution">P4S Gubuk Sayur Kabupaten Lumajang</h3>
            </td>
            <td class="header-logo-right">
                <svg width="65" height="65" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 22H22L12 2ZM12 6L18.8 19.5H5.2L12 6ZM12 10L8.5 17H15.5L12 10Z" fill="#3f6212"/>
                </svg>
            </td>
        </tr>
    </table>

    <div class="content-box">
        <div class="badge-nomor">Nomor: {{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}/P4S-GBS/SERT/{{ $bulanRomawi }}/{{ $tahunSurat }}</div>

        <div class="label-diberikan">Sertifikat ini diberikan kepada :</div>
        <div class="nama-peserta">{{ strtoupper($item->nama) }}</div>
        
        <div class="divider-flourish"></div>

        <div class="label-sebagai">sebagai</div>
        <div class="role-peserta">Peserta</div>

        <div class="keterangan-pelatihan">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Atas keberhasilannya dalam mengikuti serta menyelesaikan seluruh rangkaian agenda kegiatan 
            <strong>"Pelatihan Budidaya {{ $namaPelatihan }}"</strong> dengan durasi beban materi sebesar 
            <strong>32 Jam Pelajaran (JP)</strong>. Kegiatan vokasi pertanian ini diselenggarakan oleh Pusat Pelatihan Pertanian dan Perdesaan Swadaya (P4S) Gubuk Sayur Kabupaten Lumajang yang bertempat di Sentra Pertanian Terpadu Lumajang pada tanggal 
            {{ $tanggalResmi }}.
        </div>

        <div class="issuance-metadata">
            Lumajang, {{ $tanggalResmi }}
        </div>
    </div>

    <table class="ttd-table">
        <tr>
            <td class="ttd-col">
                <div class="label-jabatan">Instruktur / Pelatih,</div>
                <div class="wrap-signature">
                    @if(isset($img_ttd_pelatih) && $img_ttd_pelatih)
                        <img src="{{ $img_ttd_pelatih }}" alt="TTD Pelatih">
                    @endif
                </div>
                <div class="nama-penandatangan">{{ $nama_pelatih }}</div>
                <div class="sub-detail-reg">Widyaiswara Utama</div>
            </td>

            <td class="ttd-col">
                <div class="label-jabatan">Penyelenggara Kegiatan,</div>
                <div class="wrap-signature">
                    @if(isset($img_ttd_penyelenggara) && $img_ttd_penyelenggara)
                        <img src="{{ $img_ttd_penyelenggara }}" alt="TTD Penyelenggara">
                    @endif
                </div>
                <div class="nama-penandatangan">{{ $nama_penyelenggara }}</div>
                <div class="sub-detail-reg">Panitia Pelaksana</div>
            </td>

            <td class="ttd-col">
                <div class="label-jabatan">Ketua P4S Gubuk Sayur,</div>
                <div class="wrap-signature">
                    @if(isset($img_ttd_ketua) && $img_ttd_ketua)
                        <img src="{{ $img_ttd_ketua }}" alt="TTD Ketua">
                    @endif
                </div>
                <div class="nama-penandatangan">{{ $nama_ketua }}</div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>