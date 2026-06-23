<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Menampilkan halaman daftar galeri di admin
     */
    public function index()
    {
        $galeri = Galeri::latest()->get();
        return view('admin.galeri.index', compact('galeri'));
    }

    /**
     * Memproses upload foto baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Menyimpan file ke folder storage/app/public/galeri
            $path = $request->file('gambar')->store('galeri', 'public');

            Galeri::create([
                'judul' => $request->judul,
                'gambar' => $path,
            ]);

            return back()->with('success', 'Foto berhasil ditambahkan ke galeri!');
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    /**
     * Menghapus foto dari database dan folder storage
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        
        // Hapus file fisik di storage
        if ($galeri->gambar) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus!');
    }
}