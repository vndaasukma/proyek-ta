<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @author Vinda Ambitha Sukma
 */
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
            'nama_pelatihan'        => 'required|string|max:255',
            'deskripsi'             => 'required',
            'ketentuan'             => 'required',
            'tanggal_pelatihan'     => 'required|date',
            'batas_pendaftaran'     => 'required|date|before_or_equal:tanggal_pelatihan',
            'harga'                 => 'required|numeric',
            'kuota'                 => 'required|numeric',
            'status'                => 'required',
            'gambar'                => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $dataDb = [
            'title'                 => $request->nama_pelatihan,
            'description'           => $request->deskripsi,
            'ketentuan'             => $request->ketentuan,
            'tanggal_pelatihan'     => $request->tanggal_pelatihan,
            'tanggal_exp_pelatihan' => $request->batas_pendaftaran,
            'price'                 => $request->harga,
            'quota'                 => $request->kuota,
            'status'                => $request->status,
        ];

        if ($request->hasFile('gambar')) {
            $dataDb['gambar'] = $request->file('gambar')->store('pelatihan', 'public');
        }

        KelasPelatihan::create($dataDb);

        return redirect()->route('kelas-pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelatihan = KelasPelatihan::findOrFail($id);
        return view('admin.kelas_pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelatihan'        => 'required|string|max:255',
            'deskripsi'             => 'required',
            'ketentuan'             => 'required',
            'tanggal_pelatihan'     => 'required|date',
            'batas_pendaftaran'     => 'required|date|before_or_equal:tanggal_pelatihan',
            'harga'                 => 'required|numeric',
            'kuota'                 => 'required|numeric',
            'status'                => 'required',
            'gambar'                => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pelatihan = KelasPelatihan::findOrFail($id);

        $dataDb = [
            'title'                 => $request->nama_pelatihan,
            'description'           => $request->deskripsi,
            'ketentuan'             => $request->ketentuan,
            'tanggal_pelatihan'     => $request->tanggal_pelatihan,
            'tanggal_exp_pelatihan' => $request->batas_pendaftaran,
            'price'                 => $request->harga,
            'quota'                 => $request->kuota,
            'status'                => $request->status,
        ];

        if ($request->hasFile('gambar')) {
            if ($pelatihan->gambar && Storage::disk('public')->exists($pelatihan->gambar)) {
                Storage::disk('public')->delete($pelatihan->gambar);
            }
            $dataDb['gambar'] = $request->file('gambar')->store('pelatihan', 'public');
        }

        $pelatihan->update($dataDb);

        return redirect()->route('kelas-pelatihan.index')->with('success', 'Data Pelatihan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelatihan = KelasPelatihan::findOrFail($id);
        
        if ($pelatihan->gambar && Storage::disk('public')->exists($pelatihan->gambar)) {
            Storage::disk('public')->delete($pelatihan->gambar);
        }
        
        $pelatihan->delete();

        return redirect()->route('kelas-pelatihan.index')->with('success', 'Pelatihan berhasil dihapus!');
    }

    public function cetak($id)
    {
        $pelatihan = KelasPelatihan::findOrFail($id);
        return "Sedang menyiapkan fitur cetak PDF untuk: " . $pelatihan->title;
    }
}