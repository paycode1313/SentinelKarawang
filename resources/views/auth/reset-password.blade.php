@extends('layouts.app_sentinel_guest')

@section('title', 'Reset Password - Sentinel Karawang')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <div class="bmkg-card flex flex-col md:flex-row overflow-hidden min-h-[550px] shadow-2xl rounded-xl">
        
        <!-- Kolom Kiri: Branding -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center items-center text-center text-white bg-gradient-to-br from-blue-800 to-blue-900">
            <div class="mb-6">
                <i class="fas fa-key fa-4x text-white/70"></i>
            </div>
            <h1 class="text-3xl font-bold mb-3">Atur Ulang Password</h1>
            <p class="text-blue-100 max-w-xs leading-relaxed">
                Satu langkah lagi untuk mengamankan kembali akun Anda. Silakan buat password baru.
            </p>
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Password Baru</h2>
            
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-md text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $token ?? '' }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ $email ?? old('email') }}" 
                        required 
                        autofocus
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
                            onclick="togglePassword('password')"
                        >
                            <i id="eye-icon-password" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
                            onclick="togglePassword('password_confirmation')"
                        >
                            <i id="eye-icon-password_confirmation" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Reset -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(`eye-icon-${fieldId}`);
        
        if (field.type === 'password') {
            field.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection