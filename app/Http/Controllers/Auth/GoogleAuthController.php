<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah ada berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // Buat user baru
                $user = User::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()),
                    'peran' => 'admin', // default role (bisa diubah nanti)
                    'status_akun' => 'Aktif',
                ]);
            }
            
            // Login user
            Auth::login($user);
            
            // Redirect sesuai role
            return redirect()->route($user->peran . '.dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Google login gagal: ' . $e->getMessage()]);
        }
    }
}