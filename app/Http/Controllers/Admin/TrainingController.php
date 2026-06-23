<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::all();
        return view('admin.training.index', compact('trainings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'tanggal_pelatihan' => 'required|date',
            'price' => 'required|numeric',
            'quota' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trainings', 'public');
        }

        Training::create($data);

        return redirect()->back()->with('success', 'Pelatihan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $training = Training::findOrFail($id);
        
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($training->image) {
                Storage::disk('public')->delete($training->image);
            }
            $data['image'] = $request->file('image')->store('trainings', 'public');
        }

        $training->update($data);

        return redirect()->back()->with('success', 'Data pelatihan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        if ($training->image) {
            Storage::disk('public')->delete($training->image);
        }
        $training->delete();

        return redirect()->back()->with('success', 'Pelatihan berhasil dihapus!');
    }
}