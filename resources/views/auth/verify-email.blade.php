@extends('layouts.app_sentinel_guest')

@section('title', 'Verifikasi Email - Sentinel Karawang')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <div class="bmkg-card flex flex-col md:flex-row overflow-hidden min-h-[550px] shadow-2xl rounded-xl">
        
        <!-- Kolom Kiri: Branding -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center items-center text-center text-white bg-gradient-to-br from-blue-800 to-blue-900">
            <div class="mb-6">
                <i class="fas fa-envelope-check fa-4x text-white/70"></i>
            </div>
            <h1 class="text-3xl font-bold mb-3">Satu Langkah Terakhir</h1>
            <p class="text-blue-100 max-w-xs leading-relaxed">
                Kami telah mengirimkan link verifikasi ke email Anda. Silakan periksa kotak masuk untuk mengaktifkan akun Anda.
            </p>
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Verifikasi Alamat Email Anda</h2>

            <div class="mb-4 text-sm text-gray-600">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-700 bg-green-50 p-3 rounded-md border border-green-200">
                    Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto text-center py-2.5 px-4 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection