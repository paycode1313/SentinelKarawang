@extends('layouts.app_sentinel_guest')

@section('title', 'Daftar Akun - Sentinel Karawang')
@section('page-title', 'Buat Akun Baru')
@section('page-description', 'Isi form di bawah untuk membuat akun baru')

@section('content')
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md text-sm animate-fade-in">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="input-group relative animate-fade-in">
            <label for="name" class="floating-label">Nama Lengkap</label>
            <i class="fas fa-user input-icon"></i>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                class="form-input pl-12 pr-10 w-full" 
                oninput="this.parentNode.classList.toggle('input-filled', this.value !== '')"
                placeholder=" ">
        </div>

        <!-- Email Address -->
        <div class="input-group relative animate-fade-in delay-100">
            <label for="email" class="floating-label">Alamat Email</label>
            <i class="fas fa-envelope input-icon"></i>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="form-input pl-12 pr-10 w-full"
                oninput="this.parentNode.classList.toggle('input-filled', this.value !== '')"
                placeholder=" ">
        </div>

        <!-- Password -->
        <div class="input-group relative animate-fade-in delay-200">
            <label for="password" class="floating-label">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input id="password" name="password" type="password" required
                class="form-input pl-12 pr-10 w-full"
                oninput="this.parentNode.classList.toggle('input-filled', this.value !== '')"
                placeholder=" ">
            <i id="eye-icon-password" class="fas fa-eye password-toggle" onclick="togglePassword('password')"></i>
        </div>

        <!-- Confirm Password -->
        <div class="input-group relative animate-fade-in delay-300">
            <label for="password_confirmation" class="floating-label">Konfirmasi Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="form-input pl-12 pr-10 w-full"
                oninput="this.parentNode.classList.toggle('input-filled', this.value !== '')"
                placeholder=" ">
            <i id="eye-icon-password_confirmation" class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation')"></i>
        </div>

        <div class="pt-1 animate-fade-in delay-400">
            <button type="submit" class="btn-primary w-full">
                <i class="fas fa-user-plus mr-2"></i> Daftar
            </button>
        </div>
        
        <div class="text-center pt-4 animate-fade-in delay-400">
            <p class="text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 transition link-hover">Masuk di sini</a>
            </p>
        </div>
    </form>
@endsection

@push('scripts')
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