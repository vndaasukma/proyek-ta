<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pemberitahuan Jadwal Pelatihan</title>
    <style>
        body { font-family: 'Segoe UI', Helvetica, Arial, sans-serif; color: #333333; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; background: #ffffff; margin: 0 auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 6px solid #ffc107; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; color: #d39e00; font-weight: bold; }
        .info-box { background: #fff3cd; color: #856404; padding: 15px; border-radius: 6px; margin-bottom: 25px; font-size: 0.95rem; border: 1px solid #ffeeba; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        table th, table td { padding: 10px; border: 1px solid #e2e8f0; text-align: left; font-size: 0.9rem; }
        table th { background-color: #f1f5f9; color: #334155; font-weight: bold; }
        .footer { text-align: center; font-size: 0.8rem; color: #888888; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>P4S GUBUK SAYUR</h2>
            <p style="margin: 5px 0 0 0; color: #666;">Notifikasi Penting Informasi Pelaksanaan Kelas</p>
        </div>

        <p>Halo, <strong>{{ $peserta->nama }}</strong></p>
        
        <div class="info-box">
            <strong>PEMBERITAHUAN:</strong><br>
            Panitia pelaksana P4S Gubuk Sayur mengirimkan lembar info pengingat/perubahan jadwal terbaru untuk kelas pelatihan yang Anda ikuti. Mohon sesuaikan agenda kehadiran Anda dengan susunan acara di bawah ini.
        </div>

        <h4 style="color: #333; margin-bottom: 5px;">Kelas: {{ $kelas->nama_pelatihan }}</h4>
        <p style="font-size: 0.9rem; margin-top: 0;">Berikut adalah susunan agenda resmi terbaru:</p>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu (WIB)</th>
                    <th>Materi / Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas->jadwal as $jadwal)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                        <td><strong>{{ $jadwal->materi }}</strong><br><small style="color:#666;">{{ $jadwal->keterangan ?? '-' }}</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="font-size: 0.95rem; margin-top: 20px;">Apabila Anda memiliki pertanyaan lebih lanjut mengenai perubahan jam pelaksanaan ini, silakan hubungi tim Admin melalui kontak bantuan resmi di halaman profil website.</p>

        <div class="footer">
            <p>P4S Gubuk Sayur - Pelatihan Pertanian Modern Produktif & Berkelanjutan</p>
            <p>Email massal ini dikirim resmi oleh panel sistem administrasi.</p>
        </div>
    </div>
</body>
</html>