<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderJadwalMail;

/**
 * @author Vinda Ambitha Sukma
 */
class JadwalPelatihanController extends Controller
{
    public function index()
    {
        $kelasPelatihan = KelasPelatihan::with('jadwal')->latest()->get();
        return view('admin.jadwal_pelatihan.index', compact('kelasPelatihan'));
    }

    public function create($kelas_id)
    {
        $kelas = KelasPelatihan::findOrFail($kelas_id);
        return view('admin.jadwal_pelatihan.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_pelatihan_id' => 'required|exists:trainings,id',
            'tanggal'            => 'required|date',
            'jam_mulai'          => 'required',
            'jam_selesai'        => 'required',
            'materi'             => 'required|string|max:255',
            'keterangan'         => 'nullable|string',
        ]);

        JadwalPelatihan::create($request->all());

        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Agenda jadwal berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPelatihan::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Agenda jadwal berhasil dihapus!');
    }

    public function blastReminder($kelas_id)
    {
        $kelas = KelasPelatihan::with(['pendaftar' => function($query) {
            $query->where('status_pembayaran', 'Success');
        }, 'jadwal'])->findOrFail($kelas_id);

        if ($kelas->pendaftar->isEmpty()) {
            return back()->with('error', 'Tidak ada peserta dengan status pembayaran sukses untuk di-blast email.');
        }

        if ($kelas->jadwal->isEmpty()) {
            return back()->with('error', 'Jadwal agenda kelas belum diisi. Lengkapi jadwal terlebih dahulu.');
        }

        $berhasilKirim = 0;

        foreach ($kelas->pendaftar as $peserta) {
            try {
                Mail::to($peserta->email)->send(new ReminderJadwalMail($kelas, $peserta));
                $berhasilKirim++;
            } catch (\Throwable $e) {
                \Log::error('Gagal kirim email blast ke ' . $peserta->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('jadwal-pelatihan.index')
            ->with('success', 'Berhasil me-blast email pengingat / update jadwal ke ' . $berhasilKirim . ' peserta!');
    }
}