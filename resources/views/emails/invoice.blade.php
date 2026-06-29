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
        .status-badge { background: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: bold; display: inline-block; margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table td { padding: 10px 0; border-bottom: 1px dashed #e9ecef; font-size: 14px; }
        .table td.label { color: #6c757d; text-align: left; }
        .table td.value { text-align: right; font-weight: 600; color: #212529; }
        .total-row { font-size: 18px !important; font-weight: 700 !important; color: #198754 !important; border-bottom: none !important; }
        
        .rundown-title { font-size: 16px; font-weight: 700; color: #0f4c3a; margin-top: 30px; margin-bottom: 10px; border-bottom: 2px solid #198754; padding-bottom: 5px; text-align: left; }
        .table-rundown { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table-rundown th { background: #f8fafc; padding: 8px; font-size: 12px; color: #64748b; font-weight: 700; border-bottom: 2px solid #e2e8f0; text-align: left; }
        .table-rundown td { padding: 10px 8px; border-bottom: 1px solid #f1f5f9; font-size: 13px; text-align: left; color: #334155; }
        
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
                {{-- Mengambil waktu updated_at dari database dan dikonversi ke WIB (Asia/Jakarta) --}}
                <td class="value">{{ \Carbon\Carbon::parse($pendaftaran->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
            </tr>
            <tr class="total-row">
                <td class="label" style="color: #198754; font-weight: 700;">Total Harga</td>
                <td class="value">Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div class="rundown-title">Jadwal & Rundown Pelaksanaan</div>
        <table class="table-rundown">
            <thead>
                <tr>
                    <th width="25%">Tanggal</th>
                    <th width="25%">Waktu</th>
                    <th>Aktivitas / Sesi Materi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Menggunakan optional() agar sistem tidak pernah CRASH jika jadwal kosong --}}
                @forelse(optional($pendaftaran->pelatihan)->jadwal ?? [] as $j)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB</td>
                        <td>
                            <strong>{{ $j->materi }}</strong>
                            @if($j->keterangan)
                                <br><small style="color: #64748b;">{{ $j->keterangan }}</small>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #adb5bd; padding: 15px 0;">
                            Detail rundown jam pelaksanaan belum diterbitkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
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