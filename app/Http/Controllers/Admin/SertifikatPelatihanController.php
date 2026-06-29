<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasPelatihan;
use App\Models\SertifikatPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @author Vinda Ambitha Sukma
 */
class SertifikatPelatihanController extends Controller
{
    /**
     * Menampilkan daftar kelas pelatihan untuk diatur sertifikatnya
     */
    public function index()
    {
        // Ambil semua kelas pelatihan beserta relasi sertifikatnya jika ada
        $pelatihan = KelasPelatihan::with('pengaturanSertifikat')->latest()->get();
        return view('admin.sertifikat_pelatihan.index', compact('pelatihan'));
    }

    /**
     * Menampilkan form pengaturan/edit sertifikat berdasarkan ID Kelas Pelatihan
     */
    public function edit($kelas_pelatihan_id)
    {
        $pelatihan = KelasPelatihan::with('pengaturanSertifikat')->findOrFail($kelas_pelatihan_id);
        $sertifikat = $pelatihan->pengaturanSertifikat; // Bisa bernilai null jika belum pernah diatur

        return view('admin.sertifikat_pelatihan.edit', compact('pelatihan', 'sertifikat'));
    }

    /**
     * Menyimpan atau memperbarui pengaturan sertifikat kelas
     */
    public function update(Request $request, $kelas_pelatihan_id)
    {
        $request->validate([
            'is_default_template'   => 'nullable|boolean',
            'template_sertifikat'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_pelatih'          => 'nullable|string|max:255',
            'ttd_pelatih'           => 'nullable|image|mimes:png|max:2048',
            'nama_penyelenggara'    => 'nullable|string|max:255',
            'ttd_penyelenggara'     => 'nullable|image|mimes:png|max:2048',
            'nama_ketua'            => 'nullable|string|max:255',
            'ttd_ketua'             => 'nullable|image|mimes:png|max:2048',
        ]);

        $sertifikat = SertifikatPelatihan::where('kelas_pelatihan_id', $kelas_pelatihan_id)->first();

        // Jika belum ada data di database, buat instansiasi baru kosongan
        if (!$sertifikat) {
            $sertifikat = new SertifikatPelatihan();
            $sertifikat->kelas_pelatihan_id = $kelas_pelatihan_id;
        }

        // Simpan data teks teks biasa
        $sertifikat->nama_pelatih = $request->nama_pelatih;
        $sertifikat->nama_penyelenggara = $request->nama_penyelenggara;
        $sertifikat->nama_ketua = $request->nama_ketua;

        // Logika ceklis template bawaan sistem sesuai permintaanmu
        if ($request->has('is_default_template')) {
            // Jika dicentang bawaan sistem, hapus file template lama yang pernah diupload jika ada
            if ($sertifikat->template_sertifikat && Storage::disk('public')->exists($sertifikat->template_sertifikat)) {
                Storage::disk('public')->delete($sertifikat->template_sertifikat);
            }
            $sertifikat->template_sertifikat = null; // Di-null-kan agar sistem tahu menggunakan aset default
        } else {
            // Jika tidak dicentang bawaan sistem, wajib upload file baru jika belum ada gambar sebelumnya
            if ($request->hasFile('template_sertifikat')) {
                if ($sertifikat->template_sertifikat && Storage::disk('public')->exists($sertifikat->template_sertifikat)) {
                    Storage::disk('public')->delete($sertifikat->template_sertifikat);
                }
                $sertifikat->template_sertifikat = $request->file('template_sertifikat')->store('sertifikat_templates', 'public');
            }
        }

        // Proses upload file 3 tanda tangan
        $files = ['ttd_pelatih' => 'ttd', 'ttd_penyelenggara' => 'ttd', 'ttd_ketua' => 'ttd'];
        foreach ($files as $field => $path) {
            if ($request->hasFile($field)) {
                if ($sertifikat->$field && Storage::disk('public')->exists($sertifikat->$field)) {
                    Storage::disk('public')->delete($sertifikat->$field);
                }
                $sertifikat->$field = $request->file($field)->store($path, 'public');
            }
        }

        $sertifikat->save();

        return redirect()->route('admin.sertifikat.index')->with('success', 'Pengaturan komponen sertifikat kelas berhasil diperbarui!');
    }
}