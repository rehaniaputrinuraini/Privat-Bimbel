<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log; // ✅ Tambahkan untuk logging

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => "Email tidak terdaftar di sistem kami."]);
        }

        $otp = rand(100000, 999999);
        
        // Simpan ke session
        Session::put('otp', $otp);
        Session::put('otp_email', $request->email);
        Session::put('otp_expires', now()->addMinutes(5));

        try {
            // Kirim email OTP
            Mail::to($request->email)->send(new OtpMail($otp));
            
            // ✅ Log sukses
            Log::info('OTP email sent to: ' . $request->email);
            
            return redirect()->route('otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda!');
            
        } catch (\Exception $e) {
            // ✅ Log error detail
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            
            // ✅ Kalau email tetap mau dianggap sukses (karena email sudah sampai), redirect aja
            // Uncomment baris di bawah kalau mau bypass error
            // return redirect()->route('otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda!');
            
            return back()->withErrors(['email' => 'Gagal mengirim email. Error: ' . $e->getMessage()]);
        }
    }

    public function showVerifyForm()
    {
        if (!Session::get('otp_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-email');
    }

    public function verifyOtp(Request $request)
    {
        // Gabungkan input OTP jika berupa array (6 digit terpisah)
        $inputOtp = is_array($request->otp) ? implode('', $request->otp) : $request->otp;

        $storedOtp = Session::get('otp');
        $expires = Session::get('otp_expires');

        if (!$storedOtp || now()->gt($expires)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa.']);
        }

        if ($inputOtp != $storedOtp) {
            return back()->withErrors(['otp' => 'Kode OTP salah!']);
        }

        Session::put('otp_verified', true);
        return redirect()->route('password.reset');
    }

    public function showResetForm()
    {
        if (!Session::get('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = Session::get('otp_email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Bersihkan session OTP
            Session::forget(['otp', 'otp_email', 'otp_expires', 'otp_verified']);
            
            return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
        }

        return redirect()->route('password.request')->withErrors(['email' => 'User tidak ditemukan.']);
    }
}