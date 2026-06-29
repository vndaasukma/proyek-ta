<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan Pelatihan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 20px solid #198754; }
        .content { padding: 20px 0; }
        .footer { text-align: center; font-size: 0.8rem; color: #718096; margin-top: 20px; padding-top: 10px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #198754; margin: 0;">P4S Gubuk Sayur Lumajang</h2>
        </div>
        <div class="content">
            <p>Halo **{{ $item->nama }}**,</p>
            <p>Selamat! Kamu telah dinyatakan **Lulus** dan berhasil menyelesaikan seluruh rangkaian agenda kegiatan pelatihan vokasi pertanian bersama kami.</p>
            <p>Bersama dengan email ini, kami lampirkan dokumen **Sertifikat Resmi** dalam bentuk berkas PDF sebagai bukti kelulusan sah Anda pada kelas pelatihan yang diikuti.</p>
            <p>Terima kasih atas partisipasi luar biasa Anda dalam mendukung kemajuan digitalisasi pertanian lokal Indonesia.</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem Manajemen P4S Gubuk Sayur.<br>© {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>