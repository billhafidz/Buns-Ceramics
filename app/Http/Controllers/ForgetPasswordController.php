<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot_form');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:account,email',
        ]);

        $otp = rand(100000, 999999);
        session(['reset_email' => $request->email, 'reset_otp' => $otp]);

        Mail::raw("Kode OTP Anda untuk reset password adalah: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode OTP Reset Password');
        });

        return redirect()->route('otp.form')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showOtpForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')->with('error', 'Silakan masukkan email terlebih dahulu.');
        }

        $email = session('reset_email');
        return view('auth.otp_form', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if ($request->otp == session('reset_otp')) {
            session()->forget('reset_otp');
            session(['verified_email' => session('reset_email')]);
            session()->forget('reset_email');
            return redirect()->route('password.reset.form')->with('success', 'OTP berhasil diverifikasi. Silakan ubah password.');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak sesuai.']);
    }

    public function showResetForm()
    {
        if (!session()->has('verified_email')) {
            return redirect()->route('password.request')->with('error', 'Akses tidak diizinkan. Silakan mulai dari awal.');
        }

        $email = session('verified_email');
        return view('auth.reset_form', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $email = session('verified_email');

        DB::table('account')->where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('verified_email');

        return redirect()->route('index')->with('success', 'Password berhasil direset. Silakan login kembali.');
    }
}
