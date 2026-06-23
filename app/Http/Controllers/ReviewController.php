<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pelatihan' => 'required|string|max:255',
            'komentar' => 'required|string',
        ]);

        Review::create([
            'nama' => $request->nama,
            'pelatihan' => $request->pelatihan,
            'komentar' => $request->komentar,
            'status' => 'pending',
        ]);

        return back()->with('success', 'terima kasih! review kamu akan muncul setelah disetujui admin.');
    }
}