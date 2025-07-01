<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\SensorReading;
use App\Models\Incentive;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama aplikasi.
     */
    public function index(Request $request)
    {
        // Data default yang selalu diambil
        $latestReadings = SensorReading::with('sensor')->latest('recorded_at')->limit(7)->get();
        $incentives = Incentive::where('is_active', true)->get();
        
        $currentAvailablePoints = 0;
        $activities = collect();

        if (Auth::check()) {
            $user = Auth::user();
            $earnedPoints = $user->activities()->where('status', 'approved')->sum('points_earned');
            $claimedPoints = $user->userIncentives()->with('incentive')->get()->sum(function($claimed) {
                return $claimed->incentive->points_required ?? 0;
            });
            $currentAvailablePoints = $earnedPoints - $claimedPoints;
            $activities = $user->activities()->latest()->limit(5)->get();
        }

        // --- LOGIKA BARU UNTUK SENSOR TERDEKAT ---
        $nearestSensorsData = [];
        if ($request->has(['lat', 'lon'])) {
            $userLat = $request->input('lat');
            $userLon = $request->input('lon');
            $allSensors = Sensor::where('status', 'active')->get();

            $allSensors->each(function ($sensor) use ($userLat, $userLon) {
                // Rumus Haversine untuk menghitung jarak
                $earthRadius = 6371; // dalam km
                $latFrom = deg2rad($userLat);
                $lonFrom = deg2rad($userLon);
                $latTo = deg2rad($sensor->location_lat);
                $lonTo = deg2rad($sensor->location_lon);

                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;

                $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
                $sensor->distance = $angle * $earthRadius;
            });

            // Ambil 3 sensor dengan jarak terdekat
            $nearestSensors = $allSensors->sortBy('distance')->take(3);

            // Ambil data bacaan untuk 3 sensor terdekat
            foreach ($nearestSensors as $sensor) {
                $readings = SensorReading::where('sensor_id', $sensor->id)
                                ->latest('recorded_at')
                                ->take(7) // Ambil 7 data terakhir untuk grafik
                                ->get()
                                ->reverse(); // Balik urutan agar dari terlama ke terbaru
                
                $nearestSensorsData[] = [
                    'sensor' => $sensor,
                    'readings' => $readings,
                ];
            }
        }

        return view('sentinel_dashboard', [
            'latestReadings' => $latestReadings,
            'incentives' => $incentives,
            'currentAvailablePoints' => $currentAvailablePoints,
            'activities' => $activities,
            'nearestSensorsData' => $nearestSensorsData, // Kirim data baru ke view
        ]);
    }
}