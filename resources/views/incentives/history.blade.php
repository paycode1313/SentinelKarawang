@extends('layouts.app_sentinel')

@section('title', 'Riwayat Aktivitas & Klaim - Sentinel Karawang')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
    <!-- Header -->
    <header class="w-full p-6 mb-8 text-center text-white rounded-xl bg-gradient-to-r from-blue-600 to-teal-500">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2">
            Riwayat Aktivitas & Klaim Anda
        </h1>
        <p class="text-gray-200 max-w-3xl mx-auto">
            Lacak kontribusi lingkungan dan insentif yang telah Anda raih.
        </p>
    </header>

    <!-- Card Poin & Action -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 flex flex-col sm:flex-row justify-between items-center">
        <div class="text-center sm:text-left mb-4 sm:mb-0">
            <h2 class="text-xl font-semibold text-gray-700">Poin Anda Saat Ini:</h2>
            <p class="text-5xl font-extrabold text-green-600">{{ $currentAvailablePoints ?? 0 }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('incentives.create-activity') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                Laporkan Aktivitas Baru
            </a>
            <a href="{{ route('incentives.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                Lihat Program Insentif
            </a>
        </div>
    </div>

    <!-- Aktivitas -->
    <section class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Aktivitas Anda</h2>
        @if($activities->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-600">Anda belum melaporkan aktivitas apa pun.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($activities as $activity)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">{{ $activity->activity_date->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ ucfirst(str_replace('_', ' ', $activity->type)) }}</td>
                                <td class="px-4 py-3 text-sm font-bold {{ $activity->status == 'approved' ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $activity->status == 'approved' ? '+' . $activity->points_earned : '0' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($activity->status == 'pending')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @elseif($activity->status == 'approved')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        @endif
    </section>

    <!-- Klaim Insentif -->
    <section class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Klaim Insentif Anda</h2>
        @if($claimedIncentives->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-tags text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-600">Anda belum mengklaim insentif apa pun.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Klaim</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insentif</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($claimedIncentives as $claimed)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">{{ $claimed->redeemed_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $claimed->incentive->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-red-600">-{{ $claimed->incentive->points_required ?? '?' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $claimedIncentives->links() }}
            </div>
        @endif
    </section>
</div>
@endsection