<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Roboto, sans-serif; color: #333; line-height: 1.6; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .invoice-card { max-width: 500px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #eef0f2; overflow: hidden; }
        .header { background: #198754; color: white; padding: 30px 20px; text-align: center; }
        .header h2 { margin: 0; font-size: 24px; font-weight: 700; }
        .header p { margin: 5px 0 0 0; opacity: 0.8; font-size: 14px; }
        .content { padding: 30px 20px; }
        .status-badge { background: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: bold; display: inline-block; mb-4: 15px; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table td { padding: 10px 0; border-bottom: 1px dashed #e9ecef; font-size: 14px; }
        .table td.label { color: #6c757d; }
        .table td.value { text-align: right; font-weight: 600; color: #212529; }
        .total-row { font-size: 18px !important; font-weight: 700 !important; color: #198754 !important; border-bottom: none !important; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #adb5bd; background: #fdfdfd; border-top: 1px solid #f1f3f5; }
    </style>
</head>
<body>

<div class="invoice-card">
    <div class="header">
        <h2>GUBUK SAYUR</h2>
        <p>Bukti Pembayaran Pendaftaran Pelatihan</p>
    </div>
    
    <div class="content">
        <center>
            <span class="status-badge">✓ PEMBAYARAN BERHASIL</span>
        </center>
        
        <table class="table">
            <tr>
                <td class="label">No. Order</td>
                <td class="value">{{ $pendaftaran->order_id }}</td>
            </tr>
            <tr>
                <td class="label">Nama Peserta</td>
                <td class="value">{{ $pendaftaran->nama }}</td>
            </tr>
            <tr>
                <td class="label">Kelas Pelatihan</td>
                <td class="value">{{ $pendaftaran->pelatihan?->nama_pelatihan ?? 'Pelatihan Hidroponik' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Bayar</td>
                <td class="value">{{ date('d M Y H:i') }} WIB</td>
            </tr>
            <tr class="total-row">
                <td class="label" style="color: #198754; font-weight: 700;">Total Harga</td>
                <td class="value">Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <p style="font-size: 13px; color: #6c757d; text-align: center; margin-top: 25px;">
            Simpan email ini sebagai bukti kunjungan/keikutsertaan pelatihan yang sah saat di lokasi.
        </p>
    </div>
    
    <div class="footer">
        &copy; {{ date('Y') }} P4S Gubuk Sayur Lumajang. All Rights Reserved.
    </div>
</div>

</body>
</html>