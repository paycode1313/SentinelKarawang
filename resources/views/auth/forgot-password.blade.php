@extends('layouts.app_sentinel_guest')

@section('title', 'Lupa Password - Sentinel Karawang')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <div class="bmkg-card flex flex-col md:flex-row overflow-hidden min-h-[550px] shadow-2xl rounded-xl">
        
        <!-- Kolom Kiri: Branding -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center items-center text-center text-white bg-gradient-to-br from-blue-800 to-blue-900">
            <a href="/" class="mb-6">
                <img 
                    src="{{ asset('img/sentinel.logo.jpg') }}" 
                    alt="Sentinel Karawang Logo" 
                    class="h-24 w-24 rounded-full border-4 border-white/50 shadow-xl transition-transform duration-300 hover:scale-105"
                >
            </a>
            <h1 class="text-3xl font-bold mb-3">Lupa Password?</h1>
            <p class="text-blue-100 max-w-xs leading-relaxed">
                Jangan khawatir. Cukup masukkan alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang password Anda.
            </p>
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Reset Password</h2>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-700 bg-green-50 p-3 rounded-md border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-md text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <!-- Tombol Kirim Link -->
                <div>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Kirim Link Reset Password
                    </button>
                </div>
                
                <!-- Link kembali ke Login -->
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 transition text-sm">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection