<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;  // ✅ BENAR

class GoogleAuthController extends Controller
{
    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])  // ✅ TAMBAHKAN INI
            ->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah ada berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // Buat user baru dengan data dari Google
                $user = User::create([
                    'username' => $this->generateUsername($googleUser->getName()),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()),
                    'peran' => 'tentor', // Default role untuk user baru
                    'status' => 1, // Aktif
                ]);
            }
            
            // Cek status user
            if ($user->status != 1) {
                return redirect()->route('login')
                    ->withErrors(['error' => 'Akun Anda tidak aktif. Silakan hubungi admin.']);
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

    /**
     * Generate username dari nama Google
     */
    private function generateUsername($name)
    {
        // Hapus spasi dan karakter khusus
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $name);
        $username = strtolower($username);
        
        // Cek apakah username sudah ada
        $originalUsername = $username;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }
        
        return $username;
    }
}