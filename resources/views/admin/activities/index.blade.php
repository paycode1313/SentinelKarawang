@extends('layouts.app_sentinel')

@section('title', 'Manajemen Aktivitas - Admin')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Aktivitas</h1>
        <p class="text-gray-500">Setujui atau tolak laporan aktivitas dari pengguna.</p>
    </header>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bmkg-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Aktivitas</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lapor</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingActivities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 text-sm text-gray-900 font-medium">{{ $activity->user->name ?? 'Pengguna tidak ditemukan' }}</td>
                            <td class="p-3 text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $activity->type)) }}</td>
                            <td class="p-3 text-sm text-gray-500">{{ $activity->created_at->format('d M Y, H:i') }}</td>
                            <td class="p-3 text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    {{-- Tombol Setujui --}}
                                    <form action="{{ route('admin.activities.approve', $activity) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui aktivitas ini?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-green-600 hover:bg-green-700 rounded-md">Setujui</button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <form action="{{ route('admin.activities.reject', $activity) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak aktivitas ini?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-red-600 hover:bg-red-700 rounded-md">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Tidak ada aktivitas yang menunggu persetujuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection