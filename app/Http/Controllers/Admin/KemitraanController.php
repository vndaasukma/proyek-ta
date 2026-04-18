<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kemitraan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class KemitraanController extends Controller
{
    // Halaman List Kemitraan untuk Admin
    public function index()
    {
        $kemitraan = Kemitraan::latest()->get();
        return view('admin.kemitraan.index', compact('kemitraan'));
    }

    // Fungsi Simpan dari Pengunjung (Penyebab Eror Tadi)
    public function storeFront(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'no_wa' => 'required',
            'proposal' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // Upload Proposal
        $file = $request->file('proposal');
        $path = $file->store('proposals', 'public');

        Kemitraan::create([
            'nama_perwakilan' => $request->nama,
            'nama_instansi' => $request->instansi,
            'no_wa' => $request->no_wa,
            'proposal_path' => $path,
            'status' => 'pending'
        ]);

        return back()->with('success', 'permohonan kemitraan berhasil dikirim! tunggu kabar dari kami via wa.');
    }

    // Fungsi Approve
    public function approve($id)
    {
        $k = Kemitraan::findOrFail($id);
        $k->update(['status' => 'approved']);
        return back()->with('success', 'kemitraan disetujui!');
    }

    // Fungsi Reject
    public function reject($id)
    {
        $k = Kemitraan::findOrFail($id);
        $k->update(['status' => 'rejected']);
        return back()->with('success', 'kemitraan ditolak!');
    }

    // Fungsi Cetak PDF (Otomatis Sultan)
    public function cetakSurat($id)
    {
        $data = Kemitraan::findOrFail($id);
        $pdf = Pdf::loadView('admin.pdf.surat_kemitraan', compact('data'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Surat_Kemitraan_'.$data->id.'.pdf');
    }
}