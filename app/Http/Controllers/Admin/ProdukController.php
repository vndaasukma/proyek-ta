<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk di halaman admin.
     */
    public function index()
    {
        // Mengambil semua data produk urut dari yang terbaru
        $products = Produk::where('type', 'product')->latest()->get();
        
        // Mengarahkan ke file view admin/product/index.blade.php
        return view('admin.product.index', compact('products'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Simpan file fisik ke folder storage/app/public/products
            $path = $request->file('gambar')->store('products', 'public');

            // Simpan data ke tabel produks
            Produk::create([
                'title'      => $request->judul,
                'image_path' => $path,
                'type'       => 'product'
            ]);

            return back()->with('success', 'Produk berhasil ditambahkan!');
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);

        // Hapus gambar dari folder storage agar tidak menumpuk
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}