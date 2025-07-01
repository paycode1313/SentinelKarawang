<!-- resources/views/notifications/index.blade.php -->
@extends('layouts.app_sentinel')

@section('title', 'Notifikasi - Sentinel Karawang')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Notifikasi Anda</h2>
            
            <div class="space-y-4">
                @forelse ($notifications as $notification)
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all duration-200 
                                {{ $notification->unread() ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-1">
                                @if($notification->unread())
                                    <span class="h-3 w-3 bg-blue-500 rounded-full inline-block"></span>
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $notification->data['title'] ?? 'Notifikasi Sistem' }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $notification->data['message'] ?? 'Pesan tidak tersedia' }}
                                </p>
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-bell-slash text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500">Tidak ada notifikasi</p>
                    </div>
                @endforelse
            </div>
            
            @if($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection