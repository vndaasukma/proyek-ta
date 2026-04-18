<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kunjungan = Kunjungan::latest()->get();
        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kunjungan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        Kunjungan::create($request->all());

        return redirect()->route('kunjungan.index')
            ->with('success', 'Jadwal kunjungan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        return view('admin.kunjungan.edit', compact('kunjungan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        $kunjungan->update($request->all());

        return redirect()->route('kunjungan.index')
            ->with('success', 'Jadwal kunjungan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->delete();

        return back()->with('success', 'Jadwal kunjungan dihapus');
    }
}
