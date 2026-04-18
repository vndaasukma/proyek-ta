<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelasPelatihanController extends Controller
{
    public function index()
    {
        $pelatihan = KelasPelatihan::latest()->get();
        return view('admin.kelas_pelatihan.index', compact('pelatihan'));
    }

    public function create()
    {
        return view('admin.kelas_pelatihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelatihan' => 'required',
            'deskripsi'      => 'nullable',
            'harga'          => 'required|numeric',
            'kuota'          => 'required|numeric',
            'status'         => 'required|in:open,closed',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $data = $request->all();

        // Logika Upload Gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('pelatihan', 'public');
        }

        KelasPelatihan::create($data);

        return redirect()->route('kelas-pelatihan.index')
                         ->with('success', 'Pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelatihan = KelasPelatihan::findOrFail($id);
        return view('admin.kelas_pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = KelasPelatihan::findOrFail($id);

        $request->validate([
            'nama_pelatihan' => 'required',
            'harga'          => 'required|numeric',
            'kuota'          => 'required|numeric',
            'status'         => 'required|in:open,closed',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Logika Update Gambar (Hapus yang lama jika ada yang baru)
        if ($request->hasFile('gambar')) {
            if ($pelatihan->gambar) {
                Storage::disk('public')->delete($pelatihan->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('pelatihan', 'public');
        }

        $pelatihan->update($data);

        return redirect()->route('kelas-pelatihan.index')
                         ->with('success', 'Pelatihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelatihan = KelasPelatihan::findOrFail($id);
        

        if ($pelatihan->gambar) {
            Storage::disk('public')->delete($pelatihan->gambar);
        }
        
        $pelatihan->delete();

        return back()->with('success', 'Pelatihan berhasil dihapus');
    }
}