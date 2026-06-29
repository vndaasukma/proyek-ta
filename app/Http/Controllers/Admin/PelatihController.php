<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatih;
use Illuminate\Http\Request;

class PelatihController extends Controller
{
    public function index() {
        $pelatih = Pelatih::all();
        return view('admin.pelatih.index', compact('pelatih'));
    }

    public function store(Request $request) {
        $request->validate(['nama'=>'required', 'no_wa'=>'required', 'keahlian'=>'nullable']);
        Pelatih::create($request->all());
        return back()->with('success', 'Data pelatih berhasil ditambah!');
    }

    public function update(Request $request, $id) {
        $pelatih = Pelatih::findOrFail($id);
        $pelatih->update($request->all());
        return back()->with('success', 'Data pelatih berhasil diupdate!');
    }

    public function destroy($id) {
        Pelatih::findOrFail($id)->delete();
        return back()->with('success', 'Data pelatih berhasil dihapus!');
    }
}