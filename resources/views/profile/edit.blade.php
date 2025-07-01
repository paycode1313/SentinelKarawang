@extends('layouts.app_sentinel')

@section('title', 'Edit Profil - Sentinel Karawang')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Profil Akun</h1>
        <p class="text-gray-500">Kelola informasi akun, password, dan pengaturan privasi Anda.</p>
    </header>

    <div class="space-y-6">
        <!-- Kartu Update Informasi Profil -->
        <div class="bmkg-card p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Kartu Update Password -->
        <div class="bmkg-card p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Kartu Hapus Akun -->
        <div class="bmkg-card p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush