<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Kunjungan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Halo, {{ $kunjungan->nama }}!</h2>
    <p>Pendaftaran kunjungan Anda ke <strong>P4S Gubuk Sayur</strong> telah kami <strong>DISETUJUI</strong>.</p>
    
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px;">Waktu Kunjungan</td>
            <td>: {{ $kunjungan->tanggal }}</td>
        </tr>
        <tr>
            <td>Instansi</td>
            <td>: {{ $kunjungan->instansi }}</td>
        </tr>
    </table>

    <p>Silakan datang tepat waktu sesuai jadwal yang telah ditentukan. Jika ada pertanyaan, silakan hubungi kami via WhatsApp.</p>
    <br>
    <p>Salam hangat,<br><strong>Tim P4S Gubuk Sayur</strong></p>
</body>
</html>