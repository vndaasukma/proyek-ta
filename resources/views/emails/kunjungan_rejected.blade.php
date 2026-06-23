<!DOCTYPE html>
<html>
<head>
    <title>Status Reservasi Kunjungan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #dc3545; text-align: center;">Status Reservasi Kunjungan</h2>
        
        <p>Halo, <strong>{{ $data->nama_pemohon }}</strong>,</p>
        
        <p>Terima kasih atas antusiasme Anda. Mohon maaf, pengajuan reservasi kunjungan untuk instansi <strong>{{ $data->instansi }}</strong> pada tanggal <strong>{{ \Carbon\Carbon::parse($data->tanggal_kunjungan)->translatedFormat('d F Y') }}</strong> (Sesi {{ $data->sesi }}) saat ini <strong style="color: #dc3545;">BELUM BISA KAMI SETUJUI</strong>.</p>
        
        <p>Silakan hubungi admin kami melalui WhatsApp jika Anda ingin mendiskusikan atau mencari alternatif jadwal hari lain.</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 0.9em; color: #777;">
            Salam hangat,<br>
            <strong>Tim P4S Gubuk Sayur Lumajang</strong>
        </p>
    </div>
</body>
</html>