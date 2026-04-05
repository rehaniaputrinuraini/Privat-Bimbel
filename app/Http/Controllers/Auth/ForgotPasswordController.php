<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OtpMail; // Import Mailable yang sudah dibuat

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
            // KIRIM EMAIL ASLI
            Mail::to($request->email)->send(new OtpMail($otp));
            
            return redirect()->route('otp.verify.page')->with('status', 'Kode OTP telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Pastikan koneksi internet stabil.']);
        }
    }

    public function showVerifyForm()
    {
        if (!Session::get('otp_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-email'); // Sesuaikan dengan nama file blade kamu
    }

    public function verifyOtp(Request $request)
    {
        // Jika input dikirim per kotak (otp1, otp2, dst), gabungkan dulu
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
        return redirect()->route('password.reset', ['token' => 'valid']);
    }

    public function showResetForm()
    {
        if (!Session::get('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password', ['token' => 'valid']);
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

            Session::forget(['otp', 'otp_email', 'otp_expires', 'otp_verified']);
            return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
        }

        return redirect()->route('password.request');
    }
}