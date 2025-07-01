@extends('layouts.app_sentinel_guest')

@section('title', 'Login - Sentinel Karawang')
@section('page-title', 'Login')
@section('page-description', 'Masukkan kredensial Anda untuk mengakses akun')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        
        <div class="input-group relative animate-fade-in">
            <label for="email" class="floating-label">Alamat Email</label>
            <i class="fas fa-envelope input-icon"></i>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus 
                class="form-input pl-12 pr-10 w-full" 
                oninput="this.parentNode.classList.toggle('input-filled', this.value !== '')">
        </div>
        
        <div class="input-group relative animate-fade-in delay-100">
            <label for="password" class="floating-label">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input id="password" name="password" type="password" required autocomplete="current-password" 
                class="form-input pl-12 pr-10 w-full"
                oninput="this.parentNode.classList.toggle('input-filled', this.value !== '')">
            <i id="eye-icon" class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
        </div>

        <div class="flex items-center justify-between animate-fade-in delay-200">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 transition link-hover">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="pt-1 animate-fade-in delay-300">
            <button type="submit" class="btn-primary w-full">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
        </div>
        
        <div class="text-center pt-4 animate-fade-in delay-300">
            <p class="text-sm text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800 transition link-hover">Daftar di sini</a>
            </p>
        </div>
    </form>
@endsection

@push('scripts')
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
    
    // Initialize floating labels
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            if (input.value) {
                input.parentNode.classList.add('input-filled');
            }
        });
    });
</script>
@endpush