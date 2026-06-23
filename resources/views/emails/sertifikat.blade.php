<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Pelatihan P4S Gubuk Sayur</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px;">
        <h2 style="color: #198754; margin-bottom: 20px;">Halo, {{ $peserta->nama ?? $peserta->nama_pendaftar }}! 👋</h2>
        
        <p>Selamat! Kami dari segenap tim manajemen <strong>P4S Gubuk Sayur</strong> turut bangga atas keberhasilanmu menyelesaikan kelas pelatihan vokasi: 
        <strong>"{{ $peserta->pelatihan->title ?? $peserta->pelatihan->nama_pelatihan }}"</strong>.</p>
        
        <p>Sebagai bentuk apresiasi dan bukti kelulusan resmi, kami lampirkan dokumen berkas <strong>Sertifikat Digital Resmi (PDF)</strong> langsung di dalam email ini yang siap kamu unduh dan cetak kapan saja.</p>
        
        <p style="margin-top: 30px;">Semoga ilmu yang didapatkan bermanfaat bagi kemajuan ekosistem pertanian perdesaan kita ya!</p>
        
        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0 20px 0;">
        <p style="font-size: 13px; color: #718096; mb-0">Salam hangat,<br><strong>Manajemen P4S Gubuk Sayur</strong><br>Kabupaten Lumajang</p>
    </div>
</body>
</html>