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
        // Ambil data pertama. Jika tabel masih kosong, buat 1 baris kosong sebagai wadah.
        $profil = ProfilWebsite::first();

        if (!$profil) {
            $profil = ProfilWebsite::create([
                'judul'           => '',
                'deskripsi'       => '',
                'visi_judul'      => '',
                'visi_deskripsi'  => '',
                'misi_1'          => '',
                'misi_2'          => '',
                'misi_3'          => '',
                'misi_4'          => '',
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
            'misi_1' => 'required|string',
            'misi_2' => 'required|string',
            'misi_3' => 'required|string',
            'misi_4' => 'required|string',
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