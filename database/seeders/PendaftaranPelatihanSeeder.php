<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendaftaranPelatihan;
use App\Models\KelasPelatihan;
use Carbon\Carbon;

/**
 * @author
 */
class PendaftaranPelatihanSeeder extends Seeder
{
    public function run()
    {

        $kelas = KelasPelatihan::first();
        
        if (!$kelas) {
            $this->command->info('Silakan buat data Kelas Pelatihan terlebih dahulu!');
            return;
        }

        for ($i = 5; $i >= 0; $i--) {
    
            for ($j = 0; $j < 5; $j++) {
                $tanggalDummy = Carbon::now()->subMonths($i)->startOfMonth()->addDays(rand(1, 25));

                PendaftaranPelatihan::create([
                    'kelas_pelatihan_id' => $kelas->id,
                    'nama_peserta' => 'Peserta Dummy ' . rand(100, 999),
                    'status_pendaftaran' => 'success', 
                    'total_bayar' => $kelas->harga, 
                    'created_at' => $tanggalDummy, 
                    'updated_at' => $tanggalDummy,
                ]);
            }
        }
    }
}