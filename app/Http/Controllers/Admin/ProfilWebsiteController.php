<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilWebsiteController extends Controller
{
    public function index()
    {
        // Ambil data pertama. Jika tabel masih kosong, buat data default.
        $profil = ProfilWebsite::first();
        
        if (!$profil) {
            $profil = ProfilWebsite::create([
                'judul' => 'mengenal gubuk sayur.',
                'deskripsi' => 'kami berfokus pada efisiensi lahan melalui teknologi hidroponik modern untuk menciptakan ekosistem pertanian yang bersih dan cerdas.',
                'visi_judul' => 'VISI MODERN',
                'visi_deskripsi' => 'Pertanian Berbasis Data dan Sistem Nutrisi Presisi.',
                'edukasi_judul' => 'EDUKASI',
                'edukasi_deskripsi' => 'Kurikulum aplikatif bagi siswa dan petani milenial.'
            ]);
        }

        return view('admin.profil_website.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'visi_judul' => 'required|string|max:255',
            'visi_deskripsi' => 'required|string',
            'edukasi_judul' => 'required|string|max:255',
            'edukasi_deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $profil = ProfilWebsite::first();
        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($profil->gambar && Storage::disk('public')->exists($profil->gambar)) {
                Storage::disk('public')->delete($profil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('profil', 'public');
        }

        $profil->update($data);

        return redirect()->back()->with('success', 'Profil Website berhasil diperbarui!');
    }
}