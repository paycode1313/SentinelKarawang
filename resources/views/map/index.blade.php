@extends('layouts.app_sentinel')

@section('title', 'Peta Monitoring Real-Time - Sentinel Karawang')

@push('styles')
{{-- Pindahkan CSS spesifik peta ke sini agar tidak mengganggu halaman lain --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 600px; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .leaflet-popup-content-wrapper { border-radius: 0.5rem; }
    .legend { padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; }
    .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.9; border-radius: 50%; }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
    <header class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Peta Monitoring Real-Time</h1>
        <p class="mt-2 text-gray-500">Visualisasi data sensor lingkungan di seluruh wilayah Karawang.</p>
    </header>

    <div class="bmkg-card p-4">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Pindahkan JS spesifik peta ke sini --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Logika JavaScript peta Anda ditempatkan di sini
        // ... (seluruh kode JS dari file map/index.blade.php asli Anda) ...

        const map = L.map('map').setView([-6.33, 107.3], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        const sensors = @json($sensors); // Data dari MapController
        
        // ... sisa logika untuk marker, popup, legend, dll.
    });
</script>
@endpush