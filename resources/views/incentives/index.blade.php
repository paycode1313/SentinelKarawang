@extends('layouts.app_sentinel')

@section('title', 'Program Insentif - Sentinel Karawang')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
    <!-- Header -->
    <header class="w-full p-6 mb-8 text-center text-white rounded-xl bg-gradient-to-r from-blue-600 to-teal-500">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2">
            Program Insentif Lingkungan
        </h1>
        <p class="text-gray-200 max-w-3xl mx-auto">
            Berkontribusi untuk Karawang, Raih Insentif dari Pemerintah!
        </p>
    </header>

    <!-- Notifikasi -->
    <div id="notification-area" class="w-full mx-auto px-0 md:px-0 mb-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex justify-between items-center" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
                <button class="text-green-700 hover:text-green-900" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex justify-between items-center" role="alert">
                <p class="font-medium">{{ session('error') }}</p>
                <button class="text-red-700 hover:text-red-900" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
    </div>

    <!-- Card Poin & Action -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 flex flex-col sm:flex-row justify-between items-center">
        <div class="text-center sm:text-left mb-4 sm:mb-0">
            <h2 class="text-xl font-semibold text-gray-700">Poin Anda Saat Ini:</h2>
            <p class="text-5xl font-extrabold text-green-600">{{ $userPoints ?? 0 }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('incentives.create-activity') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                Laporkan Aktivitas Baru
            </a>
            <a href="{{ route('incentives.history') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                Riwayat Poin & Klaim
            </a>
        </div>
    </div>

    <!-- Daftar Insentif -->
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Insentif Tersedia</h2>
    <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-8">
        @forelse($incentives as $incentive)
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col justify-between transform transition duration-300 hover:-translate-y-1 hover:shadow-xl">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $incentive->name }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ $incentive->description }}</p>
                <div class="mt-4 text-center">
                    <span class="text-3xl font-bold text-green-700 block mb-2">{{ $incentive->points_required }} Poin</span>
                    <p class="text-gray-500 text-sm">diperlukan untuk klaim</p>
                </div>
            </div>
            <div class="mt-6">
                @auth
                    <form action="{{ route('incentives.claim', $incentive) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full font-bold py-2 px-4 rounded-lg transition duration-200 {{ ($userPoints ?? 0) >= $incentive->points_required ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}" @disabled(($userPoints ?? 0) < $incentive->points_required)>
                            {{ ($userPoints ?? 0) >= $incentive->points_required ? 'Klaim Sekarang' : 'Poin Kurang' }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-gift text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg">Belum ada program insentif yang tersedia saat ini.</p>
                <p class="text-gray-500 mt-2">Silakan cek kembali nanti.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection