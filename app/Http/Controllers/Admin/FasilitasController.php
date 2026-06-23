<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index() {
        $fasilitas = Fasilitas::all();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_fasilitas' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image'
        ]);

        $path = $request->file('gambar')->store('fasilitas', 'public');

        Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'gambar' => $path
        ]);

        return back()->with('success', 'Fasilitas berhasil ditambah!');
    }

    public function destroy($id) {
        $f = Fasilitas::findOrFail($id);
        Storage::disk('public')->delete($f->gambar);
        $f->delete();
        return back()->with('success', 'Fasilitas dihapus!');
    }
}
