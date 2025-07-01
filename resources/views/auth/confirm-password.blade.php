@extends('layouts.app_sentinel_guest')

@section('title', 'Konfirmasi Password - Sentinel Karawang')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <div class="bmkg-card flex flex-col md:flex-row overflow-hidden min-h-[550px] shadow-2xl rounded-xl">
        
        <!-- Kolom Kiri: Branding -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center items-center text-center text-white bg-gradient-to-br from-blue-800 to-blue-900">
            <div class="mb-6">
                <i class="fas fa-shield-alt fa-4x text-white/70"></i>
            </div>
            <h1 class="text-3xl font-bold mb-3">Area Aman</h1>
            <p class="text-blue-100 max-w-xs leading-relaxed">
                Untuk keamanan Anda, mohon konfirmasi password Anda untuk melanjutkan.
            </p>
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Konfirmasi Password</h2>
            
            <p class="text-sm text-gray-600 mb-6">
                Ini adalah area aman dari aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
            </p>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-md text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            autocomplete="current-password"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
                            onclick="togglePassword()"
                        >
                            <i id="eye-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Konfirmasi -->
                <div>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection