<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordController extends Controller
{
    // Tampilkan form reset password
    public function showResetForm()
    {
        // Pastikan OTP sudah diverifikasi
        if (!session('otp_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Silakan verifikasi OTP terlebih dahulu']);
        }

        $email = session('verified_email');
        return view('auth.reset-password', compact('email'));
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        // Pastikan OTP sudah diverifikasi
        if (!session('otp_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi tidak valid. Silakan mulai kembali']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Verifikasi email sesi dengan email form
        if ($request->email !== session('verified_email')) {
            return back()->withErrors(['email' => 'Email tidak sesuai dengan sesi verifikasi']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus sesi verifikasi
        session()->forget(['otp_verified', 'verified_email']);

        return redirect()->route('login')
            ->with('status', 'Password berhasil direset! Silakan login');
    }
}