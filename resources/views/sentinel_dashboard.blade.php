@extends('layouts.app_sentinel')

@section('title', 'Dashboard - Sentinel Karawang')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
    <!-- Header -->
    <header class="mb-8 bg-gradient-to-r from-blue-600 to-teal-500 rounded-xl p-6 text-white shadow-lg">
        <h1 class="text-3xl font-bold">Dashboard Monitoring</h1>
        <p class="mt-2 opacity-90">Ringkasan kondisi lingkungan Karawang saat ini</p>
        <div class="mt-4 flex items-center">
            <i class="fas fa-map-marker-alt mr-2"></i>
            <span id="location-text">Karawang, Indonesia</span>
        </div>
    </header>

    <!-- Form Pencarian -->
    <div class="mb-8">
        <form action="{{ route('search') }}" method="GET" class="relative">
            <div class="relative">
                <input type="text" name="query" placeholder="Cari cepat... (cth: 'peta', 'insentif', 'profil')" 
                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-blue-500"></i>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Kartu Sensor Terdekat -->
    @if (!empty($nearestSensorsData))
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Monitoring Sensor Terdekat</h2>
            <button id="refresh-location" class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-sync-alt mr-2"></i> Refresh
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($nearestSensorsData as $index => $data)
                @php
                    $latestValue = 'N/A';
                    $unit = '';
                    $status = [
                        'text' => 'Normal', 
                        'bg' => 'from-gray-400 to-gray-600', 
                        'icon' => 'fa-question-circle'
                    ];
                    
                    $suggestion = $data['sensor']->suggestion;
                    
                    if ($data['sensor']->latestReading) {
                        $value = is_string($data['sensor']->latestReading->value) 
                            ? json_decode($data['sensor']->latestReading->value, true) 
                            : $data['sensor']->latestReading->value;
                        
                        // Logika untuk sensor kualitas udara
                        if ($data['sensor']->type == 'air_quality' && isset($value['pm2_5'])) {
                            $latestValue = $value['pm2_5']; 
                            $unit = 'µg/m³'; 
                            $status['icon'] = 'fa-wind';
                            
                            if ($latestValue > 55) {
                                $status = [
                                    'text' => 'Tidak Sehat', 
                                    'bg' => 'from-red-500 to-red-700', 
                                    'icon' => 'fa-wind'
                                ];
                            } else {
                                $status = [
                                    'text' => 'Baik', 
                                    'bg' => 'from-green-500 to-green-600', 
                                    'icon' => 'fa-wind'
                                ];
                            }
                        } 
                        // Logika untuk sensor level air
                        elseif ($data['sensor']->type == 'water_level' && isset($value['level'])) {
                            $latestValue = $value['level']; 
                            $unit = 'cm'; 
                            $status['icon'] = 'fa-water';
                            
                            if ($latestValue > 170) {
                                $status = [
                                    'text' => 'Waspada', 
                                    'bg' => 'from-yellow-400 to-yellow-600', 
                                    'icon' => 'fa-water'
                                ];
                            } else {
                                $status = [
                                    'text' => 'Aman', 
                                    'bg' => 'from-blue-500 to-blue-700', 
                                    'icon' => 'fa-water'
                                ];
                            }
                        } 
                        // Logika untuk sensor polusi sungai
                        elseif ($data['sensor']->type == 'river_pollution' && isset($value['ph'])) {
                            $latestValue = $value['ph']; 
                            $unit = 'pH'; 
                            $status['icon'] = 'fa-flask-vial';
                            
                            if ($latestValue < 6.5 || $latestValue > 8.5) {
                                $status = [
                                    'text' => 'Tercemar', 
                                    'bg' => 'from-purple-500 to-purple-700', 
                                    'icon' => 'fa-flask-vial'
                                ];
                            } else {
                                $status = [
                                    'text' => 'Normal', 
                                    'bg' => 'from-teal-500 to-teal-600', 
                                    'icon' => 'fa-flask-vial'
                                ];
                            }
                        }
                    }
                @endphp
                
            <div class="relative rounded-xl overflow-hidden text-white p-6 flex flex-col justify-between h-48 bg-gradient-to-br {{ $status['bg'] }} transform transition duration-300 hover:scale-105">
                <div class="absolute -right-4 -bottom-4 text-white/10">
                    <i class="fas {{ $status['icon'] }} fa-8x"></i>
                </div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium">{{ $data['sensor']->name }}</p>
                        <p class="text-xs opacity-80">Jarak: ~{{ number_format($data['sensor']->distance, 1) }} km</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-white/20">
                        {{ $status['text'] }}
                    </span>
                </div>
                <div class="relative z-10">
                    <span class="text-4xl font-bold">{{ $latestValue }}</span>
                    <span class="text-lg font-medium">{{ $unit }}</span>
                </div>
                
                @if($suggestion)
                <div class="relative z-10 mt-2 bg-white/20 rounded-lg p-2 text-xs">
                    <i class="fas fa-lightbulb mr-1"></i> {{ $suggestion['message'] }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="mb-8 bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
        <i class="fas fa-map-marker-alt text-blue-500 text-4xl mb-3"></i>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Aktifkan Lokasi</h3>
        <p class="text-gray-600 mb-4">Untuk melihat data sensor terdekat, izinkan akses lokasi Anda</p>
        <button id="enable-location" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
            <i class="fas fa-location-arrow mr-2"></i> Aktifkan Lokasi
        </button>
    </div>
    @endif
    
    <hr class="my-8 border-gray-300">

    <!-- Grid Utama (Tabel dan Sidebar) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Tabel Data Sensor Terbaru -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Data Sensor Terbaru (Semua Lokasi)</h3>
                    <span class="text-xs text-gray-500">Update: {{ now()->format('H:i') }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sensor</th>
                                <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($latestReadings as $reading)
                                @php
                                    $statusTabel = ['text' => 'Normal', 'class' => 'bg-gray-100 text-gray-800'];
                                    $valueTabel = is_string($reading->value) ? json_decode($reading->value, true) : $reading->value;
                                    $icon = 'fa-question-circle';
                                    
                                    if ($reading->sensor->type == 'air_quality') {
                                        $icon = 'fa-wind text-green-500';
                                        if (isset($valueTabel['pm2_5'])) {
                                            if ($valueTabel['pm2_5'] > 55) {
                                                $statusTabel = ['text' => 'Tidak Sehat', 'class' => 'bg-red-100 text-red-800'];
                                            } else {
                                                $statusTabel = ['text' => 'Baik', 'class' => 'bg-green-100 text-green-800'];
                                            }
                                        }
                                    } elseif ($reading->sensor->type == 'water_level') {
                                        $icon = 'fa-water text-blue-500';
                                        if (isset($valueTabel['level'])) {
                                            if ($valueTabel['level'] > 170) {
                                                $statusTabel = ['text' => 'Waspada', 'class' => 'bg-yellow-100 text-yellow-800'];
                                            } else {
                                                $statusTabel = ['text' => 'Aman', 'class' => 'bg-blue-100 text-blue-800'];
                                            }
                                        }
                                    } elseif ($reading->sensor->type == 'river_pollution') {
                                        $icon = 'fa-flask-vial text-purple-500';
                                        if (isset($valueTabel['ph'])) {
                                            if ($valueTabel['ph'] < 6.5 || $valueTabel['ph'] > 8.5) {
                                                $statusTabel = ['text' => 'Tercemar', 'class' => 'bg-purple-100 text-purple-800'];
                                            } else {
                                                $statusTabel = ['text' => 'Normal', 'class' => 'bg-teal-100 text-teal-800'];
                                            }
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-3 text-sm text-gray-700 flex items-center">
                                        <i class="fas {{ $icon }} mr-2"></i>
                                        {{ $reading->sensor->name }}
                                    </td>
                                    <td class="p-3 text-sm font-medium">
                                        @if(is_array($valueTabel)) 
                                            @foreach($valueTabel as $key => $val)
                                                <div>{{ strtoupper(str_replace('_', ' ', $key)) }}: {{ $val }}</div>
                                            @endforeach 
                                        @else 
                                            <span>{{ $valueTabel }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusTabel['class'] }}">{{ $statusTabel['text'] }}</span>
                                    </td>
                                    <td class="p-3 text-sm text-gray-500">
                                        <div>{{ \Carbon\Carbon::parse($reading->recorded_at)->diffForHumans() }}</div>
                                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($reading->recorded_at)->format('H:i') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-gray-500">
                                        <i class="fas fa-database text-gray-300 text-3xl mb-2"></i>
                                        <p>Belum ada data sensor</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Grafik Tren Data Sensor -->
            @if(!empty($nearestSensorsData) && count($nearestSensorsData) > 0)
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Data Sensor Terdekat</h3>
                <div class="h-64">
                    <canvas id="sensorChart"></canvas>
                </div>
            </div>
            @endif
        </div>

        <!-- Kolom Kanan (Sidebar) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Kartu Poin & Insentif -->
            <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold">Poin & Insentif</h3>
                    <i class="fas fa-gift text-2xl opacity-80"></i>
                </div>
                
                <div class="text-center bg-white/20 p-4 rounded-lg mb-4">
                    <p class="text-sm font-medium">Poin Anda Saat Ini</p>
                    <p class="text-4xl font-bold mt-1">{{ $currentAvailablePoints ?? 0 }}</p>
                    <div class="mt-2 h-2 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-white" style="width: {{ min(($currentAvailablePoints ?? 0)/100*100, 100) }}%"></div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <a href="{{ route('incentives.index') }}" class="block w-full text-center text-sm font-medium text-green-800 bg-white hover:bg-gray-100 py-3 rounded-lg transition shadow-md">
                        <i class="fas fa-tags mr-2"></i> Lihat Semua Insentif
                    </a>
                    <a href="{{ route('incentives.create-activity') }}" class="block w-full text-center text-sm font-medium text-white bg-green-700 hover:bg-green-800 py-3 rounded-lg transition">
                        <i class="fas fa-plus-circle mr-2"></i> Laporkan Aktivitas
                    </a>
                </div>
            </div>
            
            <!-- Aktivitas Terakhir -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terakhir Anda</h3>
                    <a href="{{ route('incentives.history') }}" class="text-blue-600 text-sm hover:underline">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($activities as $activity)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <span class="flex items-center justify-center h-10 w-10 rounded-full 
                                @if($activity->status == 'approved') bg-green-100 text-green-600 
                                @elseif($activity->status == 'rejected') bg-red-100 text-red-600 
                                @else bg-yellow-100 text-yellow-600 @endif mr-3">
                                <i class="fas {{ $activity->status == 'approved' ? 'fa-check' : ($activity->status == 'rejected' ? 'fa-times' : 'fa-clock') }}"></i>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ ucfirst(str_replace('_', ' ', $activity->type)) }}</p>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-xs text-gray-500">{{ $activity->activity_date->format('d M Y') }}</p>
                                    @if($activity->status == 'approved' && $activity->points_earned)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full">
                                        +{{ $activity->points_earned }} poin
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list text-gray-300 text-3xl mb-2"></i>
                            <p class="text-sm text-gray-500">Belum ada aktivitas yang Anda laporkan</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Statistik Cepat -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Lingkungan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-3 rounded-lg text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $sensorCount ?? 0 }}</div>
                        <div class="text-xs text-gray-600">Sensor Aktif</div>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $approvedActivitiesCount ?? 0 }}</div>
                        <div class="text-xs text-gray-600">Aktivitas Disetujui</div>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $totalPointsEarned ?? 0 }}</div>
                        <div class="text-xs text-gray-600">Total Poin Diberikan</div>
                    </div>
                    <div class="bg-teal-50 p-3 rounded-lg text-center">
                        <div class="text-2xl font-bold text-teal-600">{{ $incentivesRedeemed ?? 0 }}</div>
                        <div class="text-xs text-gray-600">Insentif Diklaim</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah lokasi sudah pernah diminta sebelumnya
        const locationPermission = localStorage.getItem('locationPermission');
        const hasLocation = window.location.search.includes('lat=') && window.location.search.includes('lon=');
        
        // Jika belum pernah diminta dan tidak ada parameter lokasi
        if (!locationPermission && !hasLocation) {
            requestLocation();
        }
        
        // Tombol aktifkan lokasi
        document.getElementById('enable-location')?.addEventListener('click', requestLocation);
        
        // Tombol refresh lokasi
        document.getElementById('refresh-location')?.addEventListener('click', function() {
            this.classList.add('animate-spin');
            setTimeout(() => {
                this.classList.remove('animate-spin');
                requestLocation();
            }, 1000);
        });
        
        // Fungsi untuk meminta lokasi
        function requestLocation() {
            // Tampilkan loading
            const loadingNotice = document.createElement('div');
            loadingNotice.className = 'fixed inset-0 bg-black/50 z-50 flex items-center justify-center';
            loadingNotice.innerHTML = `
                <div class="bg-white rounded-xl p-6 text-center">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-4xl mb-3"></i>
                    <p class="text-lg font-medium">Mendapatkan lokasi Anda...</p>
                </div>
            `;
            document.body.appendChild(loadingNotice);
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // Simpan status di localStorage
                    localStorage.setItem('locationPermission', 'granted');
                    
                    // Redirect dengan lokasi
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    window.location.href = '{{ route('dashboard') }}?lat=' + latitude + '&lon=' + longitude;
                }, 
                function(error) {
                    // Sembunyikan loading
                    loadingNotice.remove();
                    
                    // Simpen status penolakan
                    localStorage.setItem('locationPermission', 'denied');
                    
                    // Tampilkan pesan error
                    alert('Akses lokasi ditolak. Anda dapat mengaktifkannya nanti melalui pengaturan browser.');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0 // Tidak gunakan cache
                }
            );
        }
        
        // Buat grafik jika ada data sensor
        @if(!empty($nearestSensorsData) && count($nearestSensorsData) > 0)
        const ctx = document.getElementById('sensorChart').getContext('2d');
        
        // Siapkan data grafik
        const chartData = {
            labels: [
                @foreach($nearestSensorsData[0]['readings'] as $reading)
                    "{{ $reading->recorded_at->format('H:i') }}",
                @endforeach
            ],
            datasets: [
                @foreach($nearestSensorsData as $data)
                {
                    label: '{{ $data["sensor"]->name }}',
                    data: [
                        @foreach($data['readings'] as $reading)
                            @php
                                $val = is_string($reading->value) 
                                    ? json_decode($reading->value, true) 
                                    : $reading->value;
                                
                                $value = 0;
                                if ($data['sensor']->type == 'air_quality' && isset($val['pm2_5'])) {
                                    $value = $val['pm2_5'];
                                } 
                                else if ($data['sensor']->type == 'water_level' && isset($val['level'])) {
                                    $value = $val['level'];
                                } 
                                else if ($data['sensor']->type == 'river_pollution' && isset($val['ph'])) {
                                    $value = $val['ph'];
                                }
                            @endphp
                            {{ $value }},
                        @endforeach
                    ],
                    borderColor: [
                        '#3B82F6', 
                        '#10B981', 
                        '#8B5CF6'
                    ][{{ $loop->index % 3 }}],
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                @endforeach
            ]
        };
        
        // Buat grafik
        new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
        @endif
    });
</script>
@endpush