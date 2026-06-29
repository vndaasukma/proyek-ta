<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Mengalihkan pengguna ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani data balik dari Google setelah user berhasil login
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari apakah user dengan email atau google_id tersebut sudah terdaftar di database
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();
            
            if ($user) {
                // Jika user ditemukan di tabel tapi belum tersambung ke google_id, update id-nya
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                
                // Login-kan user ke dalam sistem admin
                Auth::login($user);
                return redirect()->route('admin.dashboard');
            } else {
                // Proteksi jika ada orang asing login pakai Gmail yang belum didaftarkan di sistem P4S
                return redirect()->route('login')->with('error', 'Akses Ditolak! Akun Gmail Anda belum terdaftar sebagai Admin.');
            }
            
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan sistem saat mencoba masuk via Google.');
        }
    }
}