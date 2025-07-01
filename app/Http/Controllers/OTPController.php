<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtp;
use Carbon\Carbon;

class OTPController extends Controller
{
    // Tampilkan form request OTP
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }
    // Di dalam class OTPController
public function resendOTP(Request $request)
{
    $request->validate(['email' => 'required|email']);
    
    $user = User::where('email', $request->email)->first();
    
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak ditemukan'
        ], 404);
    }

    // Generate OTP baru
    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiresAt = Carbon::now()->addMinutes(10);

    // Update OTP di database
    DB::table('password_reset_otps')->updateOrInsert(
        ['email' => $user->email],
        ['otp' => $otp, 'expires_at' => $expiresAt]
    );

    // Kirim OTP baru
    Mail::to($user->email)->send(new SendOtp($otp));

    return response()->json(['success' => true]);
}
    // Kirim OTP ke email
    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        // Generate OTP 6 digit
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = Carbon::now()->addMinutes(10); // OTP berlaku 10 menit

        // Simpan OTP ke database
        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $user->email],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Kirim OTP via email
        Mail::to($user->email)->send(new SendOtp($otp));

        return redirect()->route('password.verify-otp', ['email' => $user->email])
            ->with('success', 'Kode OTP telah dikirim ke email Anda');
    }

    // Tampilkan form verifikasi OTP
    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-otp', compact('email'));
    }

    // Verifikasi OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $otpRecord = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau telah kadaluarsa']);
        }

        // Hapus OTP yang sudah digunakan
        DB::table('password_reset_otps')->where('email', $request->email)->delete();

        // Set session OTP verified
        session(['otp_verified' => true, 'verified_email' => $request->email]);

        return redirect()->route('password.reset');
    }
}