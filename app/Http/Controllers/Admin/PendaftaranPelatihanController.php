<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPelatihan;
use App\Models\KelasPelatihan;

class PendaftaranPelatihanController extends Controller
{
    public function index()
    {
        $pendaftaran = PendaftaranPelatihan::latest()->get();
        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    public function approve($id)
    {
        $data = PendaftaranPelatihan::with('pelatihan')->findOrFail($id);
        $pelatihan = $data->pelatihan;

        // Cek kuota
        if ($pelatihan->terisi >= $pelatihan->kuota) {
            return back()->with('error', 'Kuota sudah penuh!');
        }

        // Update status pendaftaran
        $data->status_pendaftaran = 'success';
        $data->save();

        // Tambah kuota terisi
        $pelatihan->increment('terisi');

        // Tutup otomatis jika penuh
        if ($pelatihan->terisi >= $pelatihan->kuota) {
            $pelatihan->update(['status' => 'closed']);
        }

        return back()->with('success', 'Peserta berhasil disetujui.');
    }

    public function tolak($id)
    {
        $data = PendaftaranPelatihan::findOrFail($id);
        $data->status_pendaftaran = 'ditolak';
        $data->save();

        return back()->with('success', 'Peserta telah ditolak.');
    }

    public function batalkan($id)
    {
        $data = PendaftaranPelatihan::with('pelatihan')->findOrFail($id);
        $pelatihan = $data->pelatihan;

        // Jika sebelumnya sudah disetujui, kurangi kuota terisi kembali
        if (strtolower($data->status_pendaftaran) == 'success' || strtolower($data->status_pendaftaran) == 'disetujui') {
            $pelatihan->decrement('terisi');
        }

        // Kembalikan ke 'pending' supaya tombol Approve muncul
        $data->status_pendaftaran = 'pending';
        $data->save();

        // Buka kembali pendaftaran jika sebelumnya tertutup
        if ($pelatihan->status == 'closed' || $pelatihan->status == 'tutup') {
            $pelatihan->update(['status' => 'open']);
        }

        return back()->with('success', 'Verifikasi dibatalkan, status kembali ke Pending.');
    }
}