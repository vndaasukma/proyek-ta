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
        // Mengambil semua data produk urut dari yang terbaru dengan tipe 'product'
        $products = Produk::where('type', 'product')->latest()->get();

        // Mengarahkan ke file view admin/product/index.blade.php
        return view('admin.product.index', compact('products'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi inputan, deskripsi opsional
        $request->validate([
            'judul'     => 'required|string|max:255',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('gambar')) {
            // Simpan file fisik ke folder storage/app/public/products
            $path = $request->file('gambar')->store('products', 'public');

            // Simpan data ke tabel produk
            Produk::create([
                'title'      => $request->judul,
                'image_path' => $path,
                'type'       => 'product',
                'deskripsi'  => $request->deskripsi,
            ]);

            return back()->with('success', 'Produk berhasil ditambahkan!');
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    /**
     * Memperbarui data produk (Nama, Deskripsi & Foto) di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi inputan, gambar dibuat nullable agar tidak wajib diganti saat edit
        $request->validate([
            'judul'     => 'required|string|max:255',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $product = Produk::findOrFail($id);

        // Jika admin mengunggah berkas foto baru untuk mengganti foto lama
        if ($request->hasFile('gambar')) {
            // Hapus file fisik foto lama dari folder storage disk public agar tidak jadi sampah
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Simpan berkas foto yang baru
            $path = $request->file('gambar')->store('products', 'public');
            $product->image_path = $path;
        }

        // Update judul & deskripsi produk
        $product->title     = $request->judul;
        $product->deskripsi = $request->deskripsi;
        $product->save();

        return back()->with('success', 'Data produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database dan storage.
     */
    public function destroy($id)
    {
        $product = Produk::findOrFail($id);

        // Hapus file gambar dari folder storage agar kapasitas disk Laragon tetap hemat
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Hapus record dari database
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}