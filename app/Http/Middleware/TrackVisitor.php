<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $hari_ini = Carbon::today()->toDateString();

        // Cari apakah IP ini sudah mengunjungi web hari ini
        $pengunjung = Pengunjung::where('ip_address', $ip)
                                ->where('tanggal', $hari_ini)
                                ->first();

        if ($pengunjung) {
            $pengunjung->increment('hits');
        } else {
            Pengunjung::create([
                'ip_address' => $ip,
                'tanggal' => $hari_ini,
                'hits' => 1
            ]); // Jika belum, buat data baru
        }

        return $next($request);
    }
}