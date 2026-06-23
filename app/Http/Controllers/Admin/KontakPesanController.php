<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakPesan;
use Illuminate\Http\Request;

class KontakPesanController extends Controller
{
    /**
     * Menerima dan menyimpan pesan dari form "Hubungi Kami"
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email',
            'no_hp'  => 'required',
            'pesan'  => 'required',
        ]);

        // 2. Simpan ke Database
        KontakPesan::create([
            'nama'   => $request->nama,
            'alamat' => $request->alamat,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'pesan'  => $request->pesan,
        ]);

        // 3. Balik lagi ke halaman kontak dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah terkirim! Admin akan segera menghubungi Anda.');
    }

    /**
     * Menampilkan daftar pesan di Dashboard Admin
     */
    public function index()
    {
        $pesans = KontakPesan::latest()->get();
        return view('admin.pesan.index', compact('pesans'));
    }

    /**
     * Menghapus pesan dari Dashboard Admin
     */
    public function destroy($id)
    {
        $pesan = KontakPesan::findOrFail($id);
        $pesan->delete();

        return back()->with('success', 'Pesan berhasil dihapus!');
    }
}